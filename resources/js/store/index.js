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
import vendor from './vendor'
import remainCatalog from "./remainCatalog";
import remain from "./remain";
import contactPerson from "./contactPerson.js";
import apiKey from "./apiKey.js";
import doc from './doc.js'
import docRemain from './docRemain.js'

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
        productCategory,
        vendor,
        remainCatalog,
        remain,
        contactPerson,
        apiKey,
        doc,
        docRemain
    }
})
