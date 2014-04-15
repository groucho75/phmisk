{include="header"}

	{* You can insert here page js/css *}

    </head>
    <body>

	   {include="top_navbar"}
	
		<div class="container">
			<div class="page-header">
				<h1><span class="glyphicon {if="isset($glyphicon)"}{$glyphicon}{else}glyphicon-asterisk{/if}"></span> {$msg}</h1>
			</div>
			<p class="lead">{$text}</p>
		</div>


{include="footer"}
