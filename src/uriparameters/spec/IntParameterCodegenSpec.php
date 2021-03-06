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

use \Facebook\HackRouter\UriParameterCodegenArgument as Arg;

final class IntParameterCodegenSpec extends SimpleParameterCodegenSpec {
  protected static function getSimpleSpec(): self::TSimpleSpec {
    return shape(
      'type' => 'int',
      'accessorSuffix' => 'Int',
    );
  }
}
