<b-collapse :open="false">
    <button class="button is-text has-text-danger" slot="trigger">Delete user</button>

    <article class="message is-danger mt-4">
		<div class="message-body">
			<p>
				Are you sure you want to do this? All information about this
				user will be permenantly deleted. <strong>Only do this if you are
				absolutely sure this is what you want.</strong>
			</p>

			<div class="level">
				<div class="level-left"></div>

				<div class="level-right">
					<form action="{{ env('APP_URL') }}/users/{{ $user->id }}" method="POST">
						{{ csrf_field() }}

						{{ method_field('delete') }}

						<div class="field">
							<div class="control">
								<button class="button is-small is-danger">
									Delete this user
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</article>
</b-collapse>