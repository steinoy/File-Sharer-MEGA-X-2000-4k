<? if ($message) : ?>
<section class="message">
	<?= $message; ?>
</section>
<? endif; ?>

<script type="text/javascript">

	_loadedEntries = {
		models: <?= json_encode($entries['models']); ?>,
		more: <?php echo $entries['more'] ? 'true' : 'false'; ?>
	}

</script>

<section id="templates" style="display:none">

	<script type="text/template" id="list-template">
		
		<input id="dropbox-file-browser" class="file-browser" name="uploads[]" type=file multiple>
		
		<div id="dropbox" class="upload">
			<div class="left"></div>
			<div class="right">
				<h2>Drop files here</h2>
				<span class="shy-button">...or open file browser</span>
			</div>
		</div>	
		
		<ul id="list-entries" class="full-width"></ul>
		<div class="append-more-entries shy-button">Load more entries...</div>
		
	</script>
	
	<script type="text/template" id="list-entry-template">
	
		<div class="left">
			
			<div class="date">
				<span class="content"><%= published %></span>
			</div>
		
		</div>
		
		<form class="right">
			
			<div class="delete entry-content"></div>
			
			<input type="text" name="title" class="h2 title" size="30" value="<%= title %>" />
			
			<p class="meta">Expires in <input size="1" name="expires" class="expiration expires" value="<%= expires %>" maxlength="2" /> days</p>
			
			<div class="content entry-content">
				<ul class="the-files"><%= filesMarkup %></ul>
				<% if (URI.length > 1) { %>
					<div class="the-URI">
						<%= URI %>
					</div>
				<% } %>
				<div class="submit-wrap">
					<div class="select-more-files shy-button">Add more files...</div>
					<input class="file-browser" name="uploads[]" type=file multiple>
				</div>
				<div class="submit-wrap <% if (uploading) { %>uploading<% } %>">
				<% if (uploading) { %>
					<div class="submit cancel">Cancel</div>
				<% } else { %>
					<div class="submit save">Save</div>
				<% } %>
					
					<div class="submit close">Close</div>
				</div>
			</div>
		
		</form>
		
	</script>
	
	<script type="text/template" id="list-entry-file-template">
		
		<li class="single-file <% if (toBeDeleted) { %>to-be-deleted<% } %> <% if (uploaded) { %> uploaded <% } %>"><%= fileName %></li>
		
	</script>
	
	<script type="text/template" id="error-template">
					
			<h2>Something went wrong:</h2>
			
			<p class="error-message"><%= options.message %></p>

			<a href="#" class="reload shy-button">
				Sorry about that, please reload the page and try again.
			</a>
				
	</script>
	
</section>