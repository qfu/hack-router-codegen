<?hh //strict
/*
 *  Copyright (c) 2016-present, Facebook, Inc.
 *  All rights reserved.
 *
 *  This source code is licensed under the BSD-style license found in the
 *  LICENSE file in the root directory of this source tree. An additional grant
 *  of patent rights can be found in the PATENTS file in the same directory.
 *
 */

namespace Facebook\HackRouter;

use Facebook\HackRouter\PrivateImpl\RequestParameterRequirementState;

use Facebook\HackCodegen\{
  IHackCodegenConfig,
  HackCodegenFactory,
  CodegenMethod
};

class RequestParameterCodegenBuilder {
  protected HackCodegenFactory $cg;

  public function __construct(
    IHackCodegenConfig $config,
  ) {
    $this->cg = new HackCodegenFactory($config);
  }

  protected static function getParameterSpecs(
  ): ImmMap<
    classname<RequestParameter>,
    classname<RequestParameterCodegenSpec>,
  > {
    return ImmMap {
      IntRequestParameter::class => IntParameterCodegenSpec::class,
      StringRequestParameter::class => StringParameterCodegenSpec::class,
      EnumRequestParameter::class => EnumParameterCodegenSpec::class,
    };
  }

  final public static function getRequestSpec(
    RequestParameter $param,
  ): classname<RequestParameterCodegenSpec> {
    $specs = self::getParameterSpecs();
    $type = get_class($param);
    invariant(
      $specs->containsKey($type),
      "Don't know how to render a %s",
      $type,
    );
    return $specs->at($type);
  }

  final public static function getUriSpec(
    UriParameter $param,
  ): classname<UriParameterCodegenSpec> {
    $spec = self::getRequestSpec($param);
    invariant(
      is_subclass_of($spec, UriParameterCodegenSpec::class),
      "Expected %s to be a %s",
      $spec,
      UriParameterCodegenSpec::class,
    );
    /* HH_FIXME[4110] can't coerce classnames */
    return $spec;
  }
}
