<b-collapse :open="false" v-cloak>
    <button class="button is-text has-text-danger" slot="trigger">
    	{{ trans('app.pages.users.buttons.deleteuser') }}
    </button>

    <article class="message is-danger mt-4">
		<div class="message-body">
			<p>
				{{ trans('app.pages.users.delete.deletemessage1') }}<strong>{{ trans('app.pages.users.delete.deletemessage2') }}</strong>
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
									{{ trans('app.pages.users.buttons.deletethisuser') }}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</article>
</b-collapse>