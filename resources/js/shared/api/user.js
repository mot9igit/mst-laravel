export default function (instance) {
    return {
        getUsers(organizationId, payload) {
            const data = instance
                .get(`/api/users/`, { params: payload })
            return data
        },
        getProfile(userId) {
            const data = instance
                .get(`/api/profile/${userId}`)
            return data
        },
        getUser(userId) {
            const data = instance
                .get(`/api/users/${userId}`)
            return data
        },
    }
}
