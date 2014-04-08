{include="header"}

	{* You can insert here page js/css *}

    </head>
    <body>

	   {include="top_navbar"}
	
		<div class="container">
			<div class="page-header">
				<h1><span class="glyphicon {$glyphicon? $glyphicon :'glyphicon-asterisk'}"></span> {$msg}</h1>
			</div>
			<ul class="lead">
			
			{loop="$posts"}
				<li>{$value.title}</li>
			{else}
				<li>No post yet.</li>
			{/loop}
			
			</ul>
		</div>


{include="footer"}
