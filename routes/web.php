<?php

use SmallRuralDog\HelpCenter\Http\Controllers\HelpCenterController;
use SmallRuralDog\HelpCenter\Http\Controllers\HelpReplyController;

Route::resource('help-center', HelpCenterController::class);

Route::resource('help-reply', HelpReplyController::class);