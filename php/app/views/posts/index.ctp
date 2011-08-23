<!-- File: /app/views/posts/index.ctp  (edit links added) -->
	
<h1>Blog posts</h1>
<p><?php echo $this->Html->link("Add Post", array('action' => 'add')); ?></p>
<table>
	<tr>
		<th>Id</th>
		<th>Title</th>
                <th>Action</th>
		<th>Created</th>
	</tr>

<!-- Here's where we loop through our $posts array, printing out post info -->

<?php foreach ($posts as $post): ?>
	<tr>
		<td><?php echo $post['Post']['id']; ?></td>
		<td>
			<?php echo $this->Html->link($post['Post']['title'], array('action' => 'view', $post['Post']['id']));?>
                </td>
                <td>
			<?php echo $this->Html->link(
				'Delete', 
				array('action' => 'delete', $post['Post']['id']), 
				null, 
				'Are you sure?'
			)?>
			<?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id']));?>
		</td>
		<td><?php echo $post['Post']['created']; ?></td>
	</tr>
<?php endforeach; ?>

</table>

