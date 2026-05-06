export default {
    state: {
        contactPersons: [],
        contactPerson: {}
    },
    actions: {
        getContactPersons ({ commit }, {org_id, filter, page, sort, perpage}) {
            const payload = {
                org_id: org_id,
                filter: filter,
                sort: sort,
                page: page,
                perpage: perpage
            }
            return this.$app.config.globalProperties.$api.contactPerson.getContactPersons(payload).then((response) => {
                commit('SET_CONTACT_PERSONS', response.data)
            })
        },
        getContactPerson ({ commit }, { contactPersonId }) {
            return this.$app.config.globalProperties.$api.contactPerson.getContactPerson(contactPersonId).then((response) => {
                commit('SET_CONTACT_PERSON', response.data)
            })
        }
    },
    mutations: {
        SET_CONTACT_PERSONS: (state, data) => {
            state.contactPersons = data
        },
        SET_CONTACT_PERSON: (state, data) => {
            state.contactPerson = data
        }
    },
    getters: {
        contactPersons (state) {
            return state.contactPersons
        },
        contactPerson (state) {
            return state.contactPerson
        }
    }
}
