<!-- Fixed navbar -->
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">{$config.site_title}</a>
			</div>
			
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="{if="CURRENT_URI == '/'"}active{/if}"><a href="{#BASE_URL#}">Home</a></li>
					<li class="{if="CURRENT_URI == '/readme'"}active{/if}"><a href="{#BASE_URL#}readme">Readme</a></li>					
					<li class="dropdown">
					<a href="#" class="dropdown-toggle needsclick" data-toggle="dropdown">Demos <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li class="dropdown-header">Custom controller</li>
						<li class="{if="CURRENT_URI == '/test'"}active{/if}"><a href="{#BASE_URL#}test">$demo->test()</a></li>

						<li class="divider"></li>
						<li class="dropdown-header">404 not found</li>
						<li><a href="{#BASE_URL#}aaaaaaa">(not-found page)</a></li>
					</ul>
					</li>
				</ul>
			</div>
			
		</div>
	</div>
