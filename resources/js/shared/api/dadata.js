export default function (instance) {
    return {
        suggestionsCompany(inn) {
            const data = instance
                .get('/api/suggestions/company', { params: { inn: inn}})
            return data
        },
        suggestionsAddress(query) {
            const data = instance
                .get('/api/suggestions/address', { params: { filter: query}})
            return data
        },
    }
}
