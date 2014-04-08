{include="header"}

	{* You can insert here page js/css *}

    </head>
    <body>

	   {include="top_navbar"}

		<div class="container">
			<div class="page-header">
				<h1><span class="glyphicon {$glyphicon? $glyphicon :'glyphicon-asterisk'}"></span> {$msg}</h1>
			</div>
			<p class="lead">{$text}</p>
		</div>

{include="footer"}
