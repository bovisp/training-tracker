<datatable 
	endpoint="{{ route('userlessons.index.api', ['user' => $user->id]) }}"
	:custom-headers="['id', 'package', 'completed']"
	:action-button="true"
	sort-key="package"
	action-button-endpoint="/users/{{ $user->id }}/userlessons/"
	action-button-text="View"
>
</datatable>