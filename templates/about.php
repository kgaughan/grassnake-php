<?php $this->with_envelope() ?>

<?php start_slot('breadcrumbs') ?>
About GrassSnake
<?php end_slot() ?>

<h1>About GrassSnake</h1>

<p><cite>GrassSnake</cite> is a minimalist and&mdash;hopefully&mdash;easy to
use bug and issue tracker written in <a href="http://php.net/">PHP</a> using
<cite>AFK</cite>, a library with a built-in miniature web application
framework. It was initially written by <a href="http://talideon.com/">Keith
Gaughan</a> on-and-off during July 2007 and was loosely based on another
bug tracker&mdash;also called GrassSnake&mdash;he wrote in ASP back in
2002.</p>

<h2>What&rsquo;s with the name?</h2>

<p>There are two reasons why GrassSnake is called &lsquo;GrassSnake&rsquo;.
Firstly, it&rsquo;s distinctive name and ought to be pretty memorable, and
secondly, grass snakes eat bugs.</p>

<h2>What were GrassSnake&rsquo;s inspirations?</h2>

<p>Most of the influence other bugtrackers had on GrassSnake was negative.
A lot of the UI and design choices I made were motivated by things I
strongly disliked about the bug trackers I&rsquo;ve used. Its strongest
anti-inspirations are <cite>Bugzilla</cite> and <cite>phpBugTracker</cite>,
both of which have terribly obtuse UIs. Most of the other open source
issue trackers aren&rsquo;t much better.</p>

<p>Minor influences were <cite>FogBugz</cite>, which I used for a while at
one of my previous jobs and which I can barely remember anything about, and the
<cite>Google Code</cite> issue tracker from which I pilfered the search form
layout and the bug template. All other similarities are co-incidental, even
the stars used for indicating watched issues, but it&rsquo;s definitely one of
the better issue trackers out there.</p>

<h2>Is there anything which needs doing?</h2>

<p>A few things:</p>

<ul>
<li>GrassSnake is currently using a hard-wired user. I need to extend
	<code>TrackerUser</code> to support IP-based users.</li>
<li>AFK has an implicit invocation system built into it. I want to get
    GrassSnake to use it to expose various event for plug-ins to respond to.
    This would mean that things which don&rsquo;t need to be part of the
    core could be pluggable, such as mailing people watching an issue when
	it&rsquo;s updated.</li>
<li>It would be nice to use my remoting code for sending the watch/unwatch
    requests back to the server, though it&rsquo; hardly necessary.</li>
<li>I need to write the search code.</li>
</ul>

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
