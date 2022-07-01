<?php
class Dashboard
{	
	// Install Dir still found.
	// --------------------------------------------------
	function installDirFound($lang)
	{		
		return <<<TEMPLATE
		<div class="warning" id="installDirFound">
			<h2>
				<span>{$lang['dashboard']['warningHeader']}</span>
				<a href="javascript: void(0);" onclick="Effect.toggle('installDirFound', 'appear', {duration: 0.3});">X</a>
				<div style="clear: both;"></div>
			</h2>
			<ul>
				<li class="problem">{$lang['dashboard']['warningProblem']}</li>
				<li class="solution">{$lang['dashboard']['warningSolution']}</li>
			</ul>
		</div>

TEMPLATE;
	}
		
	// Dashboard heading.
	// --------------------------------------------------
	function heading($installDirFound)
	{
		return <<<TEMPLATE
	
		{$installDirFound}
		<div id="dashboard">
			<div id="dashboardLeft">	

		
TEMPLATE;
	}
	
	
	// Rss heading.
	// --------------------------------------------------
	function rssBlogHeading($rs)
	{
		return <<<TEMPLATE
		
		<h2>{$rs['title']} RSS Feed</h2>
		<div class="table-faux">
			<ul>

TEMPLATE;
	}	
	
	// Rss loop.
	// --------------------------------------------------
	function rssBlogLoop($item)
	{
		return <<<TEMPLATE
		
		<li><a href="{$item['link']}">{$item['title']}</a><em>{$item['description']}</em></li>

TEMPLATE;
	}	
	
	// Rss footer.
	// --------------------------------------------------
	function rssBlogFooter()
	{
		return <<<TEMPLATE
		
				</ul>
			</div>

TEMPLATE;
	}				
	
	// Dashboard no rss blog found.
	// --------------------------------------------------
	function rssBlogNotFound($lang)
	{
		return <<<TEMPLATE
		
		<h2>Err, no blog feed found!</h2>
		<div class="table-faux">Please contact your web consultant.</div>	

TEMPLATE;
	}	
	
	// Dashboard left footer
	// --------------------------------------------------
	function leftFooter()
	{
		return <<<TEMPLATE
		
		</div>	

TEMPLATE;
	}		
	
	// Open area to allow you to add your own unique feature.
	// --------------------------------------------------
	function openAreaForUniqueUse($lang)
	{
		return <<<TEMPLATE
		
		<div id="dashboardRight">
			<h2>{$lang['dashboard']['openAreaHeader']}</h2>
			<div class="table-faux">
	            {$lang['dashboard']['openAreaText']}
			</div>

TEMPLATE;
	}		
	
	// Open area to allow you to add your own unique feature.
	// --------------------------------------------------
	function openAreaForUniqueUse_2($lang)
	{
		return <<<TEMPLATE
		    
			<h2 style="margin-top: 10px;">{$lang['dashboard']['openAreaHeader']}</h2>
			<div class="table-faux">
	            {$lang['dashboard']['openAreaText']}
			</div>
		</div>		    		    

TEMPLATE;
	}	
	
	// Dashboard footer.
	// --------------------------------------------------
	function footer()
	{
		return <<<TEMPLATE
		
		</div>
		<div style="clear: both;"></div>		

TEMPLATE;
	}
} // End of Dashboard.

$Html = new Dashboard;
?>