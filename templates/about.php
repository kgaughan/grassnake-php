<?php $this->with_envelope() ?>

<?php start_slot('breadcrumbs') ?>
About GrassSnake
<?php end_slot() ?>

<h1>About GrassSnake</h1>

<p><img src="assets/images/logo.png" width="76" height="95" alt="GrassSnake"
style="float:right" title="Holy crap! It&rsquo;s a logo!">
<cite>GrassSnake</cite> is a minimalist and&mdash;hopefully&mdash;easy to use
bug and issue tracker written in <a href="http://php.net/"
title="Training wheels">PHP</a> using <cite title="Bicycle">AFK</cite>, a
library with a built-in miniature web application framework. It was initially
written by <a href="http://talideon.com/" title="Yours truly">Keith Gaughan</a>
on-and-off during July 2007 and was loosely based on another bug
tracker&mdash;also called GrassSnake&mdash;he wrote in ASP back in 2002.</p>

<h2>What&rsquo;s with the name?</h2>

<p>There are two reasons why GrassSnake is called &lsquo;GrassSnake&rsquo;.
Firstly, it&rsquo;s distinctive name and ought to be pretty memorable, and
secondly, grass snakes eat bugs.</p>

<h2>What were GrassSnake&rsquo;s inspirations?</h2>

<p>Most of the influence other bugtrackers had on GrassSnake was negative.
A lot of the UI and design choices I made were motivated by things I
strongly disliked about the bug trackers I&rsquo;ve used. Its strongest
anti-inspirations are <cite title="A jet-powered Cessna">Bugzilla</cite>
and <cite title="Same, with a foggy windscreen">phpBugTracker</cite>, both of
which have terribly obtuse UIs. Most of the other open source issue trackers
aren&rsquo;t much better. Trac I remain puzzled by.</p>

<p>Minor influences were <cite>FogBugz</cite>, which I used for a while at
one of my previous jobs and which I can barely remember anything about, and the
<cite>Google Code</cite> issue tracker from which I pilfered the search form
layout and the bug template. All other similarities are co-incidental, even
the stars used for indicating watched issues, but it&rsquo;s definitely one of
the better issue trackers out there.</p>

<h2>Is there anything which needs doing?</h2>

<p>A few things:</p>

<ul>
<li>It would be nice to use my remoting code for sending the watch/unwatch
    requests back to the server, though it&rsquo;s hardly necessary.</li>
<li>I need to write the search code.</li>
<li>Issue merging.</li>
<li>An actual admin backend of some kind, but this&rsquo;d be a separate
    application, most likely restricted to user management.</li>
</ul>

<h2>Is there anything GrassSnake is definitely never going to do?</h2>

<p>Oh, yeah! It&rsquo;s issue metadata isn&rsquo;t going to grow any greater
than it already is. It&rsquo;s never going to include task tracking as I
believe that&rsquo;s something better left to an external tool and its
presence in GrassSnake could easily lead to management doing nasty, misleading
things with pseudo-metrics. I can&rsquo;t see it ever having a wiki built
into it any time soon either, and I have yet to see the benefits of using
an issue tracker as a project management tool beyond keeping track of
enhancement requests and the like.</p>

<p>It may get SCM integration at some point though...</p>

<h2>Licence details?</h2>

<p>Thought you&rsquo;d never ask.</p>

<div class="licence">

<p>The compilation of software known as GrassSnake is distributed under the
following terms:</p>

<p>Copyright &copy; Keith Gaughan, 2007. All Rights Reserved.</p>

<p>Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:</p>

<ol>
<li>Redistributions of source code must retain the above copyright notice,
    this list of conditions and the following disclaimer.</li>
<li>Redistributions in binary form must reproduce the above copyright
    notice, this list of conditions and the following disclaimer in the
	documentation and/or other materials provided with the distribution.</li>
</ol>

<p>THIS SOFTWARE IS PROVIDED BY AUTHOR AND CONTRIBUTORS &lsquo;AS IS&rsquo; AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL AUTHOR OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE
OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.</p>

<p>This licence is subject to the laws of the Republic of Ireland and the
European Union.</p>

</div>

<p>There, not all that painful.</p>
