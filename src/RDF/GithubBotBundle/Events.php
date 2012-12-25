<?php
/*
 * This file is part of ONP
 *
 * Copyright (c) 2012 Farheap Solutions (http://www.farheap.com)
 *
 * The unauthorized use of this code outside the boundaries of
 * Farheap Solutions Inc. is prohibited.
 */

namespace RDF\GithubBotBundle;

/**
 * @author Richard Fullmer <richard.fullmer@opensoftdev.com>
 */
final class Events
{
    const BUILD_TRIGGERED = 'build.triggered';
    const BUILD_STARTED = 'build.started';
    const BUILD_FINISHED = 'build.finished';
}
