export default function (instance) {
    return {
        getDocs(payload) {
            return instance
                .get(`/api/integration/store/document`, {params: payload})
        },
        getDoc(storeId, docId) {
            return instance
                .get(`/api/integration/store/${storeId}/document/${docId}`)
        },
    }
}
