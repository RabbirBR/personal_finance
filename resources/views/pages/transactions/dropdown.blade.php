<select required class="form-control account_head input-sm select2">
	<option value=""></option>
	@foreach($account_heads as $head)
	<option @if($head->ledger == 0) disabled @endif value='{{ $head->id }}'>{{ $head->name }}</option>

	<?php
	if(isset($head->children)){
		$parent_str = $head->name." -> ";
		showChildOptions($head->children, 1, $parent_str, $selected_id);
	}
	?>
	@endforeach
</select>

<?php

function showChildOptions($children, $mult, $parent_str, $selected_id){
	$indent = $mult*2;

	if(isset($children)){
		foreach ($children as $head) {
			if($head->ledger == 0){
				echo "<option disabled value='".$head->id."'>";
			}
			else{
				if($head->id == $selected_id){
					echo "<option selected value='".$head->id."'>";
				}
				else{
					echo "<option value='".$head->id."'>";
				}
				
			}
			
			/*for ($i=0; $i < $indent; $i++) { 
				echo "&nbsp;&nbsp";
			}*/
			/*if($head->ledger == 0){
				echo $head->name."</option>";
			}
			else{
				echo $parent_str.$head->name."</option>";
			}*/

			echo $parent_str.$head->name."</option>";

			
			?>

			<?php
			$new_parent_str = $parent_str.$head->name." -> ";
			showChildOptions($head->children, ($mult+1), $new_parent_str, $selected_id);
		}
	}
}

?>