import Vuex from 'vuex'

import user from './user'
import organization from './organization'
import requisite from './requisite'
import bankRequisite from './bankRequisite'
import productCategory from './productCategory'

export default new Vuex.Store({
    modules: {
        user,
        organization,
        requisite,
        bankRequisite,
        productCategory
    }
})
