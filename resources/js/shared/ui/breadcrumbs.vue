<template>
  <a class="d-back promotions__top-back products__back" @click="$router.go(-1)">
    <i class="d-icon-arrow d-back__icon"></i>
    <span class="d-back__text hidden-640">Назад</span>
  </a>
  <ul class="d-breadcrumbs d-top-breadcrumbs">
    <template v-for="(crumb, index) in crumbs" :key="index">
      <li
        class="d-breadcrumbs__item d-top-breadcrumbs-item"
        v-if="crumb"
        :class="{ active: index === crumbs.length - 1 }"
      >
        <router-link :to="crumb.path" class="d-breadcrumbs__button">{{ crumb.name }}</router-link>
      </li>
    </template>
  </ul>
</template>
<script>
import router from '@/router'
import { mapGetters } from 'vuex'

export default {
  name: 'BreadcrumbsComponent',
  data() {
    return {
      crumbs: [],
    }
  },
  computed: {
    ...mapGetters({
      orgActive: 'org/orgActive',
      sale: 'sales/sale',
      order: 'retail/order',
      optCatalog: 'catalog/optCatalog',
      optCatalogWarehouse: 'catalog/optCatalogWarehouse',
    }),
    breadcrumbs() {
      const currentRoute = router.currentRoute.value
      const fullPath = currentRoute.matched[currentRoute.matched.length - 1].path
      const pathRoutes = fullPath.split('/')
      const pathRoutesWithId = currentRoute.fullPath.split('/')

      const routeMatched = this.$route.matched
      const breadcrumbs = pathRoutes.map((route, index) => {
        // console.log(route)
        if (
          route == '/' ||
          route == '' ||
          (!route.startsWith(':') &&
            !routeMatched.find(
              (matchedRoute) => matchedRoute.path === pathRoutes.slice(0, index + 1).join('/'),
            )?.meta.breadcrumb?.label)
        ) {
          return
        }
        if (route.startsWith(':')) {
          return {
            name: this.getRouteName(currentRoute, route),
            path: pathRoutesWithId.slice(0, index + 1).join('/'),
          }
        }
        if (pathRoutes[pathRoutes.length - 1] == ':category_id') {
          const parents = this.getCategoriesCatItemParents(4, currentRoute.params.category_id)

          parents?.forEach((parent) => {
            const newPathRoutesWithId = pathRoutesWithId.map((path) => path)
            newPathRoutesWithId[newPathRoutesWithId.length - 1] = parent.id

            // breadcrumbs.splice(-1, 0, {
            //   name: parent?.pagetitle,
            //   path: newPathRoutesWithId.join('/'),
            // })
          })
        }

        return {
          name: routeMatched.find(
            (matchedRoute) => matchedRoute.path === pathRoutes.slice(0, index + 1).join('/'),
          )?.meta.breadcrumb?.label,
          path: pathRoutesWithId.slice(0, index + 1).join('/'),
        }
      })
      return breadcrumbs
    },
  },
  mounted() {
    this.updateCrumbs()
  },
  methods: {
    updateCrumbs() {
      this.crumbs = []
      const currentRoute = router.currentRoute.value
      if (currentRoute.fullPath != '/') {
        // console.log(currentRoute)
        const fullPath = currentRoute.matched[currentRoute.matched.length - 1].path
        const pathRoutes = fullPath.split('/')
        const pathRoutesWithId = currentRoute.fullPath.split('/')
        const routeMatched = this.$route.matched

        // console.log(pathRoutes)
        // console.log(pathRoutesWithId)
        // console.log(routeMatched)

        pathRoutes.forEach((route, index) => {
          // console.log(route)
          if (
            route == '/' ||
            route == '' ||
            (!route.startsWith(':') &&
              !routeMatched.find(
                (matchedRoute) => matchedRoute.path === pathRoutes.slice(0, index + 1).join('/'),
              )?.meta.breadcrumb?.label)
          ) {
            return
          }
          if (route.startsWith(':')) {
            switch (route) {
              case ':action_id': {
                this.crumbs.push({
                  name: this.sale.name,
                  path: pathRoutesWithId.join('/'),
                  type: 'purchasesCatalog',
                  params: currentRoute.params,
                })
                break
              }
              case ':category_id': {
                const parents = this.getCategoriesCatItemParents(4, currentRoute.params.category_id)
                parents?.forEach((parent) => {
                  pathRoutesWithId[pathRoutesWithId.length - 1] = parent.id
                  this.crumbs.push({
                    name: parent?.pagetitle,
                    path: pathRoutesWithId.join('/'),
                    type: 'purchasesCatalog',
                    params: currentRoute.params,
                  })
                })
                break
              }
              case ':warehouse_cat_id': {
                const parents = this.getWarehouseCatItemParents(
                  'warehouse_org_' + currentRoute.params.org_w_id,
                  'warehouse_org_' +
                    currentRoute.params.org_w_id +
                    '_' +
                    currentRoute.params.warehouse_cat_id,
                )
                // console.log(parents)
                parents?.forEach((parent, i) => {
                  const param = {
                    id: currentRoute.params.id,
                  }
                  if (Object.prototype.hasOwnProperty.call(parent, 'org_w_id')) {
                    param.org_w_id = parent.org_w_id
                  }
                  if (Object.prototype.hasOwnProperty.call(parent, 'warehouse_id')) {
                    param.warehouse_id = parent.warehouse_id
                  }
                  if (Object.prototype.hasOwnProperty.call(parent, 'id')) {
                    if (parent.id != 'all') {
                      param.warehouse_cat_id = parent.id
                    }
                  }
                  const len = pathRoutesWithId.length - (parents.length - i - 1)
                  if (
                    Object.prototype.hasOwnProperty.call(param, 'warehouse_cat_id') &&
                    i == parents.length - 1
                  ) {
                    pathRoutesWithId[pathRoutesWithId.length - 1] = param.warehouse_cat_id
                  }
                  this.crumbs.push({
                    name: parent?.pagetitle,
                    path: pathRoutesWithId.slice(0, len).join('/'),
                    type: 'purchasesCatalogWarehouse',
                    params: param,
                  })
                })
                break
              }
              case ':order_id': {
                if (Object.prototype.hasOwnProperty.call(this.order, 'order')) {
                  this.crumbs.push({
                    name: '№ ' + this.order.order.num,
                    path: pathRoutesWithId.slice(0, index + 1).join('/'),
                  })
                }
                break
              }
              case ':id':
              case ':requirement_id': {
                this.crumbs.push({
                  name: this.getRouteName(currentRoute, route),
                  path: pathRoutesWithId.slice(0, index + 1).join('/'),
                })
                break
              }
              default:
                // this.crumbs.push({
                //   name: this.getRouteName(currentRoute, route),
                //   path: pathRoutesWithId.slice(0, index + 1).join('/'),
                // })
                break
            }
          } else {
            const label = routeMatched.find(
              (matchedRoute) => matchedRoute.path === pathRoutes.slice(0, index + 1).join('/'),
            )?.meta.breadcrumb?.label
            if (label) {
              this.crumbs.push({
                name: label,
                path: pathRoutesWithId.slice(0, index + 1).join('/'),
              })
            }
          }
        })
      }
    },
    getRouteName(currentRoute, param) {
      // console.log("Current route: ", currentRoute);
      // console.log("Current route param: ", param);
      switch (param) {
        case ':id': {
          return this.orgActive.name_short ? this.orgActive.name_short : this.orgActive.name
        }
        case ':order_id': {
          return `Заказ № ${currentRoute.params?.order_id || '-'}`
        }
        case ':action_id': {
          return this.sale.name
        }
        case ':search': {
          return `Поиск: ${this.$route.query.search}`
        }
        case ':requirement_id': {
          const text = currentRoute.params?.requirement_id.split('_')
          return `Потребность № ${text[0] || '-'}`
        }
      }
    },
    getCatItem(id, catalog = this.optCatalogWarehouse, key = 'id') {
      for (var i in catalog) {
        if (catalog[i][key] == id) {
          return catalog[i]
        } else {
          if (Object.prototype.hasOwnProperty.call(catalog[i], 'children')) {
            let res = this.getCatItem(id, catalog[i].children, key)
            if (res) {
              return res
            }
          }
        }
      }
    },
    getWarehouseCatItemParents(stopId, catItemId) {
      const catItem = this.getCatItem(catItemId, this.optCatalogWarehouse, 'key')
      // console.log(catItem)
      if (!catItem) return
      if (catItem?.parent == 0) return
      let parents = this.getAllParents(stopId, catItem, [], this.optCatalogWarehouse, 'key')
      parents.push(catItem)
      return parents
    },
    getCategoriesCatItemParents(stopId, catItemId) {
      const catItem = this.getCatItem(catItemId, this.optCatalog)
      // console.log('Searched catItem', catItem)

      if (!catItem) return
      if (catItem?.parent == 0) return

      let parents = this.getAllParents(stopId, catItem, [], this.optCatalog)
      parents.push(catItem)
      return parents
    },
    getAllParents(stopId, catItem, parents, catalog, key = 'id') {
      // console.log(catalog)
      if (catItem[key] == stopId) return parents
      let currParent = this.getCatItem(catItem?.parent, catalog, key)
      if (currParent) {
        parents.unshift(currParent)
        this.getAllParents(stopId, currParent, parents, catalog, key)
      }
      return parents
    },
  },
  watch: {
    optCatalog: function () {
      this.updateCrumbs()
    },
    sale: function () {
      this.updateCrumbs()
    },
    order: function () {
      this.updateCrumbs()
    },
    optCatalogWarehouse: function () {
      this.updateCrumbs()
    },
    orgActive: function () {
      this.updateCrumbs()
    },
    $route() {
      this.updateCrumbs()
    },
  },
}
</script>
<style lang="scss"></style>
