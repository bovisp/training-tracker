<template>
	<section class="section" style="position: relative;">
		<div class="columns">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Status
				</h2>
			</div>
		</div>

		<div class="columns is-desktop">
			<Status 
				v-for="status in statuses"
				:key="status.period"
				:status="status"
			/>
		</div>

		<article class="message is-danger mt-4" v-if="filteredKeys(errors, /statuses/).length">
			<div class="message-body">
				<div class="content">
					<ul class="mt-0">
						<li v-for="error in filteredKeys(errors, /statuses/)">
							{{ errors[error][0] }}
						</li>
					</ul>
				</div>
			</div>
		</article>

		<div class="columns mt-8">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Objectives
				</h2>
			</div>
		</div>

		<div class="columns">
			<div class="column">
				<Objectives />
			</div>
		</div>
		
		<template v-if="logbooks.length > 0">
			<div class="columns mt-8">
				<div class="column">
					<h2 class="title is-2 has-text-weight-light">
						Logbooks
					</h2>
				</div>
			</div>

			<div class="columns">
				<div class="column">
					<NewEntryDropdown 
						v-if="allObjectivesRequiringLogbooks === false && hasRoleOf(['apprentice', 'supervisor'])"
					/>

					<Logbooks />
				</div>
			</div>
		</template>

		<div class="columns mt-8">
			<div class="column">
				<h2 class="title is-2 has-text-weight-light">
					Statement of Competency
				</h2>
			</div>
		</div>

		<comments 
			:endpoint="commentsEndpoint"
			:create-roles="['supervisor', 'head_of_operations']"
			:is-completed="allObjectivesComplete && statusComplete"
		/>

		<div 
			style="position: fixed; bottom: 0; left: 0; background: #FFF; display: flex; width: 100%; z-index: 10;"
			class="p-4 has-background-white-ter" 
			v-if="hasRoleOf(['supervisor', 'head_of_operations', 'manager'])"
		>
				<button 
					class="button is-info ml-auto"
					@click="submit"
				>
					<i class="mdi mdi-content-save mr-2"></i>

					{{ trans('app.components.userlessons.save') }}
				</button>
		</div>

		<EntryModal />

		<b-loading :active.sync="isLoading"></b-loading>
	</section>
</template>

<script>
	import { mapActions, mapGetters, mapMutations } from 'vuex'
	import Objectives from './objectives/Objectives'
	import NewEntryDropdown from './logbooks/NewEntryDropdown'
	import Logbooks from './logbooks/Logbooks'
	import EntryModal from './logbooks/EntryModal'
	import Status from './statuses/Status'
	import Comments from '../comments/Comments'

	export default {
		props: {
			userlessonId: {
				type: Number,
				required: true
			},
			user: {
				type: Object,
				required: true
			}
		},

		components: {
			Objectives,
			NewEntryDropdown,
			Logbooks,
			EntryModal,
			Status,
			Comments
		},

		computed: {
			...mapGetters({
				userlesson: 'userlessons/userlesson',
				logbooks: 'userlessons/logbooks',
				statuses: 'userlessons/statuses',
				statusComplete: 'userlessons/statusComplete',
				isLoading: 'userlessons/isLoading',
				form: 'userlessons/form',
				allObjectivesComplete: 'userlessons/allObjectivesComplete' 
			}),

			commentsEndpoint () {
				return `/users/${this.user.id}/userlessons/${this.userlessonId}/comments`
			},

			allObjectivesRequiringLogbooks () {
				let objectivesRequiringLogbooks = _.map(this.logbooks, logbook => {
					if (logbook.objective.notebook_required == 1) {
						return logbook.objective.id
					}
				})

				let intersection = _.intersection(objectivesRequiringLogbooks, this.form.completedObjectives)

				if (intersection.length === objectivesRequiringLogbooks.length) {
					return true
				}

				return false
			}
		},

		methods: {
			...mapActions({
				fetch: 'userlessons/fetch',
				update: 'userlessons/update',
				reset: 'userlessons/reset'
			}),

			...mapMutations({
				updateLoading: 'userlessons/UPDATE_LOADING'
			}),

			async submit () {
				this.updateLoading()

				let response = await this.update()

				this.updateLoading()

				if (response.status === 200) {
					await this.fetch({userlesson: this.userlessonId, user: this.user.id})

      		this.$buefy.toast.open({
				message: response.data.flash,
				position: 'is-top-right',
				type: 'is-success'
			})
				}

				if (response.status === 422) {
					await this.reset()

					this.$toast.open({
		                message: response.data.message,
		                position: 'is-top-right',
		                type: 'is-danger'
	        		})
				}
			},

			filteredKeys (obj, filter) {
				let key, keys = []

				for (key in obj) {
					if (obj.hasOwnProperty(key) && filter.test(key)) {
						keys.push(key)
					}
				}

	  			return keys
			}
		},

		mounted () {
			console.log(this.userlessonId, this.user.id)
			this.fetch({userlesson: this.userlessonId, user: this.user.id})

			window.events.$on('comment:saved', () => {
				console.log("here")
				this.fetch({userlesson: this.userlessonId, user: this.user.id})
			})
		}
	}
</script>