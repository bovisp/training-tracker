<datatable 
	endpoint="{{ route('userlessons.index.api', ['user' => $user->id]) }}"
	:custom-headers="['id', 'number', 'name', 'completed']"
	:action-button="true"
	sort-key="package"
	action-button-endpoint="/users/{{ $user->id }}/userlessons/"
	action-button-text="View"
>
</datatable>