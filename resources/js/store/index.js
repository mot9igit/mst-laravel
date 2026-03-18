import Vuex from 'vuex'

import user from './user'
import organization from './organization'

export default new Vuex.Store({
    modules: {
        user,
        organization
    }
})
