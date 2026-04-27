import instance from './instance'

import baseModule from '@/shared/api/base.js'
import authModule from '@/pages/sign-in/api/auth'
import dadataModule from "@/shared/api/dadata.js";
import countryModule from "@/shared/api/country.js";
import regionModule from "@/shared/api/region.js";
import cityModule from "@/shared/api/city.js";
import organizationModule from "@/shared/api/organization.js";
import storeModule from "@/shared/api/store.js";
import userModule from "@/shared/api/user.js";
import requisiteModule from "@/shared/api/requisite.js";
import bankRequisiteModule from "@/shared/api/bankRequisite.js";
import productCategoryModule from "@/shared/api/productCategory.js";
import vendorModule from "@/shared/api/vendor.js";

export default {
    base: baseModule(instance),
    auth: authModule(instance),
    dadata: dadataModule(instance),
    country: countryModule(instance),
    region: regionModule(instance),
    city: cityModule(instance),
    organization: organizationModule(instance),
    store: storeModule(instance),
    user: userModule(instance),
    requisite: requisiteModule(instance),
    bankRequisite: bankRequisiteModule(instance),
    productCategory: productCategoryModule(instance),
    vendor: vendorModule(instance),
}
