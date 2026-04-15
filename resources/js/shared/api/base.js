export default function (instance) {
    return {
        get(url, payload) {
            return instance
                .get(url, { params: payload })
        },
        post(url, payload) {
            return instance
                .post(url, payload)
        },
        patch(url, payload) {
            return instance
                .patch(url, payload)
        },
        delete(url, payload) {
            return instance
                .delete(url, payload)
        },
    }
}
