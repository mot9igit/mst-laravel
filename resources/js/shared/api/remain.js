export default function (instance) {
    return {
        getRemains(storeId, payload) {
            const data = instance
                .get(`/api/integration/store/${storeId}/remain`, {params: payload})
            return data
        },
        getRemain(storeId, remainId) {
            const data = instance
                .get(`/api/integration/store/${storeId}/remain/${remainId}`)
            return data
        },
        getRemainPrices(storeId, remainId, payload) {
            const data = instance
                .get(`/api/integration/store/${storeId}/remain/${remainId}/price`, {params: payload})
            return data
        },
        getRemainPrice(storeId, remainId, priceId) {
            const data = instance
                .get(`/api/integration/store/${storeId}/remain/${remainId}/price/${priceId}`)
            return data
        },
        getRemainHistories(storeId, remainId, payload) {
            const data = instance
                .get(`/api/integration/store/${storeId}/remain/${remainId}/history`, {params: payload})
            return data
        },
        getRemainHistory(storeId, remainId, historyId) {
            const data = instance
                .get(`/api/integration/store/${storeId}/remain/${remainId}/history/${historyId}`)
            return data
        }
    }
}
