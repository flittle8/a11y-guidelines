<?php include_once('../../includes/xml-declaration.php'); ?>
<?php $id='sc025'; $nav=1; $nav_items=array( 'ex','reqs'); $category='script'; $page_name='Live Regions'; ?>
<!DOCTYPE html>
<html xml:lang="en" lang="en"
	xmlns="http://www.w3.org/1999/xhtml"
	xmlns:epub="http://www.idpf.org/2007/ops">
	
	<head>
		<meta charset="utf-8"/>
		<?php include_once('../../includes/title.php'); ?>
		<?php include_once('../../includes/html5-shiv.php'); ?>
		<link type="text/css" rel="stylesheet" href="../../css/epub3.css"/>
		<?php include_once('../../includes/js.php'); ?>
		<style type="text/css">
			dt { font-weight: bold; }
			.incorrect { color: rgb(120,0,0); font-weight: bold; }
			.correct { color: rgb(0,120,0); font-weight: bold; }
			form { margin-left: 3em; }
			label { display: block }
			input { margin-top: 0.5em; }
			div#result { margin-top: 0.75em; margin-left: 3em; }
		</style>
	</head>
	
	<body>
		<?php include_once('../../includes/header.php'); ?>
		
		<section id="sc025" class="section">
			<?php include_once('../../includes/page-title.php'); ?>
			
			<section id="sc025-desc" class="usage">
				<p>Scripting changes to the DOM can dynamically change the text. While sighted readers may see
					such changes, they may not be presented to readers using assistive technologies. An 
					assistive technology will typically build its own copy of the DOM to operate on, so
					unless you alert it of a change, the new information will not be made available.</p>
				
				<p epub:type="bridgehead">Creating a live region</p>
				
				<p>To solve this problem, the WAI-ARIA specification includes the 
					<code><a href="http://www.w3.org/TR/wai-aria/states_and_properties#aria-live">aria-live</a></code> attribute.
					When set, this attribute indicates that text is expected to be dynamically written to the element, ensuring
					that when changes do occur they get picked up by the assistive technology.</p>
				
				<pre class="prettyprint linenums"><code>&lt;div
     id="results"
     aria-live="assertive"/></code></pre>
				
				<p>When the attribute is set to the value <code class="value">assertive</code> it indicates that 
					changes should be announced to the reader as soon as they are written. When set to
					<code class="value">polite</code>, changes should be announced to the reader 
					during an idle period.</p>
				
				<p epub:type="bridgehead">Controlling playback</p>
				
				<p>It's not always the case that you want updates read as they happen. The 
					<code><a href="http://www.w3.org/TR/wai-aria/states_and_properties#aria-busy">aria-busy</a></code>
					attribute can be used to tell the reading system to wait before announcing changes to the reader.
					Set the attribute to <code class="value">true</code> before writing. The reading system will
					wait until the attribute is changed back to <code class="value">false</code> before announcing
					the changes.</p>
				
				<pre class="prettyprint linenums"><code>&lt;div
     id="results"
     aria-live="assertive"
     aria-busy="false"/></code></pre>
				
				<p epub:type="bridgehead">Controlling what's read</p>
				
				<p>WAI-ARIA also includes the 
					<code><a href="http://www.w3.org/TR/wai-aria/states_and_properties#aria-atomic">aria-atomic</a></code>
					attribute for further control over what gets read. When set to <code class="value">true</code>, all 
					text inside the element gets read regardless of what has been updated. When set to 
					<code class="value">false</code>, the reading system will only read the changed text.</p>
				
				<pre class="prettyprint linenums"><code>&lt;div
     id="results"
     aria-live="assertive"
     aria-busy="false"
     aria-atomic="true"/></code></pre>
				
				<p epub:type="bridgehead">Controlling what gets noticed</p>
				
				<p>The 
					<code><a href="http://www.w3.org/TR/wai-aria/states_and_properties#aria-relevant">aria-relevant</a></code>
					attribute can be used to control the type of updates to read: element additions (<code class="value">additions</code>),
					element deletions  (<code class="value">removals</code>), text changes (<code class="value">text</code>)
					or all changes (<code class="value">all</code>).</p>
				
				<pre class="prettyprint linenums"><code>&lt;div
     id="results"
     aria-live="assertive"
     aria-busy="false"
     aria-atomic="true"
     aria-relevant="all"/></code></pre>
				
				<p epub:type="bridgehead">Default live regions</p>
				
				<p>Setting any of the following values for an element's <code>role</code> attribute automatically
					makes them live: <code class="value">alert</code>, <code class="value">log</code>, 
					<code class="value">marguee</code>, <code class="value">status</code> and 
					<code class="value">timer</code>.</p>
				
				<pre class="prettyprint linenums"><code>&lt;div
     id="results"
     role="alert"/></code></pre>
			</section>
			
			<section id="sc025-ex" class="example">
				<h3>Example</h3>
				<figure id="sc025-ex01">
					<figcaption>Example 1 &#8212; A simple form that display the result</figcaption>
					<pre class="prettyprint linenums small"><code>&lt;form>
   &lt;div id="q1">
      What is the capital of Sweden?
      
      &lt;label for="q1a">
         &lt;input
                type="radio"
                id="q1a"
                name="q1"/>a. Innsbruck
      &lt;/label>
      
      &lt;label for="q1b">
         &lt;input
                type="radio"
                id="q1b"
                name="q1"/>b. Oslo
      &lt;/label>
      
      &lt;label for="q1c">
         &lt;input
                type="radio"
                id="q1c"
                name="q1"/>c. Stockholm
      &lt;/label>
      
      &lt;label for="q1d">
         &lt;input
                type="radio"
                id="q1d"
                name="q1"/>d. Uppsala
      &lt;/label>
   &lt;/div>
   
   &lt;input
          type="button"
          value="Verify"
          onclick="checkAnswers()"/>
&lt;/form>

&lt;div
     id="result"
     aria-live="assertive"
     aria-atomic="true"
     hidden="hidden">
   Your answer is &lt;span id="q1-answer"/>!
&lt;/div>

&lt;script type="text/javascript">
&lt;![CDATA[

function checkAnswers() {
   var q1ans = document.getElementById('q1-answer');

   while (q1ans.hasChildNodes()) {
      q1ans.removeChild(q1ans.firstChild);
   }
   
   var response = document.getElementById('q1c').checked ? 'correct' : 'incorrect';
   
   q1ans.appendChild(document.createTextNode(response));
   q1ans.className = response;
   
   var result = document.getElementById('result');
   
   result.removeAttribute('hidden');
}

]]&gt;
&lt;/script></code></pre>
					
					<p>A working example of this code follows.</p>
					
					<form>
						<div id="q1">
							What is the capital of Sweden?
							<label for="q1a"><input type="radio" id="q1a" name="q1" onclick="activate()"/>a. Innsbruck</label>
							<label for="q1b"><input type="radio" id="q1b" name="q1" onclick="activate()"/>b. Oslo</label>
							<label for="q1c"><input type="radio" id="q1c" name="q1" onclick="activate()"/>c. Stockholm</label>
							<label for="q1d"><input type="radio" id="q1d" name="q1" onclick="activate()"/>d. Uppsala</label>
						</div>
						<input type="button" id="checkButton" value="Verify" disabled="disabled" aria-disabled="true" onclick="checkAnswers()"/>
					</form>
					<div id="result" aria-live="assertive" aria-atomic="true" hidden="hidden">
						Your answer is <span id="q1-answer"></span>!
					</div>
					<script type="text/javascript">
					<![CDATA[
						function activate() {
							var checkButton = document.getElementById('checkButton');
							
							if (checkButton.disabled) {
								checkButton.removeAttribute('disabled');
								checkButton.setAttribute('aria-disabled', 'false');
								document.getElementById('q1a').removeAttribute('onclick');
								document.getElementById('q1b').removeAttribute('onclick');
								document.getElementById('q1c').removeAttribute('onclick');
								document.getElementById('q1d').removeAttribute('onclick');
							}
						}
						
						function checkAnswers() {
							var q1ans = document.getElementById('q1-answer');
							
							while (q1ans.hasChildNodes()) {
								q1ans.removeChild(q1ans.firstChild);
							}
							
							var response = document.getElementById('q1c').checked ? 'correct' : 'incorrect';
							
								q1ans.appendChild(document.createTextNode(response));
								q1ans.className = response;
							
							var result = document.getElementById('result');
								result.removeAttribute('hidden');
						}
					]]>
					</script>
				</figure>
			</section>
			
			<section id="sc025-reqs" class="reqs">
				<h3>Compliance References and Standards</h3>
				
				<ul>
					<li>WAI-ARIA &#8212; <a href="http://www.w3.org/TR/wai-aria/states_and_properties#attrs_liveregions">Live Region Attributes</a></li>
					<li>WAI-ARIA &#8212; <a href="http://www.w3.org/TR/wai-aria/roles#role_definitions">Definition of Roles</a></li>
				</ul>
			</section>
		</section>
		
		<?php include_once('../../includes/footer.php'); ?>
	</body>
</html>