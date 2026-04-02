import Vuex from 'vuex'

import user from './user'
import organization from './organization'
import requisite from './requisite'

export default new Vuex.Store({
    modules: {
        user,
        organization,
        requisite
    }
})
