export default function (instance) {
    return {
        getApiKeys(payload) {
            return instance
                .get('/api/integration/api-key', {params: payload})
        },
        getApiKey(apiKeyId) {
            return instance
                .get(`/api/integration/api-key/${apiKeyId}`)
        },
    }
}
