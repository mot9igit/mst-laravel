import Vuex from 'vuex'

import user from './user'
import country from './country'
import region from './region'
import city from './city'
import organization from './organization'
import store from './store'
import requisite from './requisite'
import bankRequisite from './bankRequisite'
import productCategory from './productCategory'

export default new Vuex.Store({
    modules: {
        user,
        country,
        region,
        city,
        organization,
        store,
        requisite,
        bankRequisite,
        productCategory
    }
})
