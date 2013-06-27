<h1>Register</h1>
<form class="well" method="post" action="<?php eh(url('')) ?>">
	<label>Your name:</label>
	<input type="text" class="span2" name="username" value="">
	<label>Password:</label>
	<input type="password" class="span2" name="password" value="">
	<input type="hidden"  name="thread_id" value="">
	<input type="hidden"  name="page_next" value="register_end">
	</br>
	<button type="submit" class="btn btn-primary">Register</button>
</form>
