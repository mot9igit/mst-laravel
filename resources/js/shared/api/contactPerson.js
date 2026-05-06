export default function (instance) {
    return {
        getContactPersons(payload) {
            return instance
                .get('/api/integration/contact-person', {params: payload})
        },
        getContactPerson(contactPersonId) {
            return instance
                .get(`/api/integration/contact-person/${contactPersonId}`)
        },
    }
}
