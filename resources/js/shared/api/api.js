import instance from './instance'

import authModule from '@/pages/sign-in/api/auth'
import organizationModule from "@/shared/api/organization.js";
import userModule from "@/shared/api/user.js";
import requisiteModule from "@/shared/api/requisite.js";
import bankRequisiteModule from "@/shared/api/bankRequisite.js";
import productCategoryModule from "@/shared/api/productCategory.js";

export default {
    auth: authModule(instance),
    organization: organizationModule(instance),
    user: userModule(instance),
    requisite: requisiteModule(instance),
    bankRequisite: bankRequisiteModule(instance),
    productCategory: productCategoryModule(instance),
}
