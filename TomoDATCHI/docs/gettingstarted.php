<?php
include_once('header.php');
?>

<h1 class="bd-title" id="content">Getting Started</h1>
<h2 id="quick-start">Setting Up the Database</h2>
From cPanel, scroll to the Databases section and select MySQL Databases.
Create a new database, named after what the new species is
Click back, and add adoptape_admin as a new user to this database. Assign them all privileges.

<h2 id="quick-start">Setting Up DeviantArt Login</h2>
<h3>Creating the database to store user login information</h3>
- Navigate to the phpMyAdmin database manager, navigate to the new database you made.
CREATE TABLE siteusers (userid INT(11), username VARCHAR(20), deviantartid VARCHAR(36), type VARCHAR(5));
INSERT INTO `siteusers`(`userid`, `username`, `deviantartid`, `type`) VALUES (1,"Pepper-Wood","0F3BF59C-B171-B193-42F9-993F7AD2F433","admin");

<h3>Creating the application with DeviantArt</h3>
- Login to the authorized moderator/masterlist account
- Load URL <a href="https://www.deviantart.com/developers/apps">https://www.deviantart.com/developers/apps</a>. There's now way to get to this page without this link for an account with no applications.
- Click <b>Register Application</b>

Dummy picture
Title of application
Brief description of application

OAuth2 Grant Type					Authorization Code
OAuth2 Redirect URI Whitelist		https://adoptapedia.com/FOLDERNAME/
(space-separated)					https://adoptapedia.com/FOLDERNAME/login.php
									https://CUSTOMURL.com
									https://CUSTOMURL.com/login.php
Download URL						[ leave blank ]
Original URLs Whitelist				https://adoptapedia.com/FOLDERNAME/ https://CUSTOMURL.com

- Back in the developer portal, click Publish for the application
- Screenshot the the client_id and client_secret for preservation, along with sending the text of the client_id and client_secret

8836
bbc089f6eabc86d5ae238d26df45b4d0

<h3>Hooking everything together</h3>
Start by copying logintest.php to the new website folder.

Copy all of the files in the "Default Template" folder to get started.
- in login.php, replace the client_id and client_secret with the newly obtained authorizations, replace the URLs that all mention Jabberwock
- You will also need to go into util/User.php in the parent directory and add a function to add users through this method



Setting up other databases
CREATE TABLE messages (messageid INT(11), userid INT(11), type VARCHAR(10), messagedate INT(8), messagetext VARCHAR(1000));
CREATE TABLE items (itemid INT(11), itemname VARCHAR(30), itemimage VARCHAR(200));
CREATE TABLE inventories (ownerid INT(11), quantity INT(11), itemid INT(11));
CREATE TABLE masterlist (charaid INT(11), speciesid INT(11), visualid INT(11), charaimg VARCHAR(100), ownername VARCHAR(25), ownerid INT(11), designername VARCHAR(25), designerid INT(11));
CREATE TABLE species (speciesid INT(11), speciesname VARCHAR(30));

<p class="bd-lead">Get started with Bootstrap, the world’s most popular framework for building responsive, mobile-first sites, with BootstrapCDN and a template starter page.</p>
<h2 id="quick-start">Quick start</h2>
<p>Looking to quickly add Bootstrap to your project? Use BootstrapCDN, provided for free by the folks at StackPath. Using a package manager or need to download the source files? <a href="/docs/4.1/getting-started/download/">Head to the downloads page.</a></p>
<h3 id="css">CSS</h3>
<p>Copy-paste the stylesheet <code class="highlighter-rouge">&lt;link&gt;</code> into your <code class="highlighter-rouge">&lt;head&gt;</code> before all other stylesheets to load our CSS.</p>
<figure class="highlight">
	<pre><code class="language-html" data-lang="html"><span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"</span> <span class="na">integrity=</span><span class="s">"sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"</span> <span class="na">crossorigin=</span><span class="s">"anonymous"</span><span class="nt">&gt;</span></code></pre>
</figure>
<h3 id="js">JS</h3>
<p>Many of our components require the use of JavaScript to function. Specifically, they require <a href="https://jquery.com">jQuery</a>, <a href="https://popper.js.org/">Popper.js</a>, and our own JavaScript plugins. Place the following <code class="highlighter-rouge">&lt;script&gt;</code>s near the end of your pages, right before the closing <code class="highlighter-rouge">&lt;/body&gt;</code> tag, to enable them. jQuery must come first, then Popper.js, and then our JavaScript plugins.</p>
<p>We use <a href="https://blog.jquery.com/2016/06/09/jquery-3-0-final-released/">jQuery’s slim build</a>, but the full version is also supported.</p>
<figure class="highlight">
	<pre><code class="language-html" data-lang="html"><span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"https://code.jquery.com/jquery-3.3.1.slim.min.js"</span> <span class="na">integrity=</span><span class="s">"sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"</span> <span class="na">crossorigin=</span><span class="s">"anonymous"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"</span> <span class="na">integrity=</span><span class="s">"sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"</span> <span class="na">crossorigin=</span><span class="s">"anonymous"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"</span> <span class="na">integrity=</span><span class="s">"sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"</span> <span class="na">crossorigin=</span><span class="s">"anonymous"</span><span class="nt">&gt;&lt;/script&gt;</span></code></pre>
</figure>
<p>Curious which components explicitly require jQuery, our JS, and Popper.js? Click the show components link below. If you’re at all unsure about the general page structure, keep reading for an example page template.</p>
<p>Our <code class="highlighter-rouge">bootstrap.bundle.js</code> and <code class="highlighter-rouge">bootstrap.bundle.min.js</code> include <a href="https://popper.js.org/">Popper</a>, but not <a href="https://jquery.com/">jQuery</a>. For more information about what’s included in Bootstrap, please see our <a href="/docs/4.1/getting-started/contents/#precompiled-bootstrap">contents</a> section.</p>
<details>
	<summary class="text-primary mb-3">Show components requiring JavaScript</summary>
	<ul>
		<li>Alerts for dismissing</li>
		<li>Buttons for toggling states and checkbox/radio functionality</li>
		<li>Carousel for all slide behaviors, controls, and indicators</li>
		<li>Collapse for toggling visibility of content</li>
		<li>Dropdowns for displaying and positioning (also requires <a href="https://popper.js.org/">Popper.js</a>)</li>
		<li>Modals for displaying, positioning, and scroll behavior</li>
		<li>Navbar for extending our Collapse plugin to implement responsive behavior</li>
		<li>Tooltips and popovers for displaying and positioning (also requires <a href="https://popper.js.org/">Popper.js</a>)</li>
		<li>Scrollspy for scroll behavior and navigation updates</li>
	</ul>
</details>
<h2 id="starter-template">Starter template</h2>
<p>Be sure to have your pages set up with the latest design and development standards. That means using an HTML5 doctype and including a viewport meta tag for proper responsive behaviors. Put it all together and your pages should look like this:</p>
<figure class="highlight">
	<pre><code class="language-html" data-lang="html"><span class="cp">&lt;!doctype html&gt;</span>
<span class="nt">&lt;html</span> <span class="na">lang=</span><span class="s">"en"</span><span class="nt">&gt;</span>
<span class="nt">&lt;head&gt;</span>
<span class="c">&lt;!-- Required meta tags --&gt;</span>
<span class="nt">&lt;meta</span> <span class="na">charset=</span><span class="s">"utf-8"</span><span class="nt">&gt;</span>
<span class="nt">&lt;meta</span> <span class="na">name=</span><span class="s">"viewport"</span> <span class="na">content=</span><span class="s">"width=device-width, initial-scale=1, shrink-to-fit=no"</span><span class="nt">&gt;</span>

<span class="c">&lt;!-- Bootstrap CSS --&gt;</span>
<span class="nt">&lt;link</span> <span class="na">rel=</span><span class="s">"stylesheet"</span> <span class="na">href=</span><span class="s">"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"</span> <span class="na">integrity=</span><span class="s">"sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"</span> <span class="na">crossorigin=</span><span class="s">"anonymous"</span><span class="nt">&gt;</span>

<span class="nt">&lt;title&gt;</span>Hello, world!<span class="nt">&lt;/title&gt;</span>
<span class="nt">&lt;/head&gt;</span>
<span class="nt">&lt;body&gt;</span>
<span class="nt">&lt;h1&gt;</span>Hello, world!<span class="nt">&lt;/h1&gt;</span>

<span class="c">&lt;!-- Optional JavaScript --&gt;</span>
<span class="c">&lt;!-- jQuery first, then Popper.js, then Bootstrap JS --&gt;</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"https://code.jquery.com/jquery-3.3.1.slim.min.js"</span> <span class="na">integrity=</span><span class="s">"sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"</span> <span class="na">crossorigin=</span><span class="s">"anonymous"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"</span> <span class="na">integrity=</span><span class="s">"sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"</span> <span class="na">crossorigin=</span><span class="s">"anonymous"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="nt">&lt;script </span><span class="na">src=</span><span class="s">"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"</span> <span class="na">integrity=</span><span class="s">"sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"</span> <span class="na">crossorigin=</span><span class="s">"anonymous"</span><span class="nt">&gt;&lt;/script&gt;</span>
<span class="nt">&lt;/body&gt;</span>
<span class="nt">&lt;/html&gt;</span></code></pre>
</figure>
<p>That’s all you need for overall page requirements. Visit the <a href="/docs/4.1/layout/overview/">Layout docs</a> or <a href="/docs/4.1/examples/">our official examples</a> to start laying out your site’s content and components.</p>
<h2 id="important-globals">Important globals</h2>
<p>Bootstrap employs a handful of important global styles and settings that you’ll need to be aware of when using it, all of which are almost exclusively geared towards the <em>normalization</em> of cross browser styles. Let’s dive in.</p>
<h3 id="html5-doctype">HTML5 doctype</h3>
<p>Bootstrap requires the use of the HTML5 doctype. Without it, you’ll see some funky incomplete styling, but including it shouldn’t cause any considerable hiccups.</p>
<figure class="highlight">
	<pre><code class="language-html" data-lang="html"><span class="cp">&lt;!doctype html&gt;</span>
<span class="nt">&lt;html</span> <span class="na">lang=</span><span class="s">"en"</span><span class="nt">&gt;</span>
...
<span class="nt">&lt;/html&gt;</span></code></pre>
</figure>
<h3 id="responsive-meta-tag">Responsive meta tag</h3>
<p>Bootstrap is developed <em>mobile first</em>, a strategy in which we optimize code for mobile devices first and then scale up components as necessary using CSS media queries. To ensure proper rendering and touch zooming for all devices, <strong>add the responsive viewport meta tag</strong> to your <code class="highlighter-rouge">&lt;head&gt;</code>.</p>
<figure class="highlight">
	<pre><code class="language-html" data-lang="html"><span class="nt">&lt;meta</span> <span class="na">name=</span><span class="s">"viewport"</span> <span class="na">content=</span><span class="s">"width=device-width, initial-scale=1, shrink-to-fit=no"</span><span class="nt">&gt;</span></code></pre>
</figure>
<p>You can see an example of this in action in the <a href="#starter-template">starter template</a>.</p>
<h3 id="box-sizing">Box-sizing</h3>
<p>For more straightforward sizing in CSS, we switch the global <code class="highlighter-rouge">box-sizing</code> value from <code class="highlighter-rouge">content-box</code> to <code class="highlighter-rouge">border-box</code>. This ensures <code class="highlighter-rouge">padding</code> does not affect the final computed width of an element, but it can cause problems with some third party software like Google Maps and Google Custom Search Engine.</p>
<p>On the rare occasion you need to override it, use something like the following:</p>
<figure class="highlight">
	<pre><code class="language-css" data-lang="css"><span class="nc">.selector-for-some-widget</span> <span class="p">{</span>
<span class="nl">box-sizing</span><span class="p">:</span> <span class="n">content-box</span><span class="p">;</span>
<span class="p">}</span></code></pre>
</figure>
<p>With the above snippet, nested elements—including generated content via <code class="highlighter-rouge">::before</code> and <code class="highlighter-rouge">::after</code>—will all inherit the specified <code class="highlighter-rouge">box-sizing</code> for that <code class="highlighter-rouge">.selector-for-some-widget</code>.</p>
<p>Learn more about <a href="https://css-tricks.com/box-sizing/">box model and sizing at CSS Tricks</a>.</p>
<h3 id="reboot">Reboot</h3>
<p>For improved cross-browser rendering, we use <a href="/docs/4.1/content/reboot/">Reboot</a> to correct inconsistencies across browsers and devices while providing slightly more opinionated resets to common HTML elements.</p>
<h2 id="community">Community</h2>
<p>Stay up to date on the development of Bootstrap and reach out to the community with these helpful resources.</p>
<ul>
	<li>Follow <a href="https://twitter.com/getbootstrap">@getbootstrap on Twitter</a>.</li>
	<li>Read and subscribe to <a href="https://blog.getbootstrap.com">The Official Bootstrap Blog</a>.</li>
	<li>Join <a href="https://bootstrap-slack.herokuapp.com">the official Slack room</a>.</li>
	<li>Chat with fellow Bootstrappers in IRC. On the <code class="highlighter-rouge">irc.freenode.net</code> server, in the <code class="highlighter-rouge">##bootstrap</code> channel.</li>
	<li>Implementation help may be found at Stack Overflow (tagged <a href="https://stackoverflow.com/questions/tagged/bootstrap-4"><code class="highlighter-rouge">bootstrap-4</code></a>).</li>
	<li>Developers should use the keyword <code class="highlighter-rouge">bootstrap</code> on packages which modify or add to the functionality of Bootstrap when distributing through <a href="https://www.npmjs.com/browse/keyword/bootstrap">npm</a> or similar delivery mechanisms for maximum discoverability.</li>
</ul>
<p>You can also follow <a href="https://twitter.com/getbootstrap">@getbootstrap on Twitter</a> for the latest gossip and awesome music videos.</p>


<?php
include_once('footer.php');
?>
