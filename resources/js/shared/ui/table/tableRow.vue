<template>
  <tr
    v-if="Object.keys(link_row).length === 0"
    class="d-table__row"
    :class="{
      'd-table__row-padding': classRow,
      'd-table__row-noactive': row_data.no_available == 1,
    }"
  >
    <v-table-cell
      v-for="(row, index) in keys"
      :key="index"
      :cell_data="row"
      :cell_key="index"
      :value="row_data"
      :selectedItems="this.selectedItems"
      :editMode="editMode"
      @deleteElem="deleteElem"
      @updateElem="updateElem"
      @viewElem="viewElem"
      @editElem="editElem"
      @clickElem="clickElem"
      @checkElem="checkElem"
      @approveElem="approveElem"
      @disapproveElem="disapproveElem"
      @editNumber="editNumber"
      @actionCell="actionCell"
      @rowClass="rowClass"
      @saleModal="saleModal"
    />
  </tr>
  <tr
    v-else
    class="d-table__row"
    :class="{
      'd-table__row-padding': classRow,
      'd-table__row-noactive': row_data.no_available == 1,
    }"
  >
    <v-table-cell
      v-for="(row, index) in keys"
      :key="index"
      :cell_data="row"
      :cell_key="index"
      :value="row_data"
      :selectedItems="this.selectedItems"
      :editMode="editMode"
      @deleteElem="deleteElem"
      @updateElem="updateElem"
      @editElem="editElem"
      @viewElem="viewElem"
      @clickElem="clickElem"
      @checkElem="checkElem"
      @approveElem="approveElem"
      @disapproveElem="disapproveElem"
      @editNumber="editNumber"
      @actionCell="actionCell"
      @rowClass="rowClass"
      @saleModal="saleModal"
      @click.prevent="
        $router.push({
          name: link_row.link_to,
          params: linkParams(row),
          props: link_row.link_props,
        })
      "
      style="cursor: pointer"
    />
  </tr>
  <slot name="add_data"></slot>
</template>

<script>
import vTableCell from './tableCell.vue'

export default {
  name: 'v-table-row',
  emits: [
    'deleteElem',
    'updateElem',
    'viewElem',
    'editElem',
    'clickElem',
    'checkElem',
    'approveElem',
    'disapproveElem',
    'editNumber',
    'actionCell',
    'saleModal',
  ],
  props: {
    editMode: {
      type: Boolean,
      default: false,
    },
    row_data: {
      type: Object,
      default: () => {
        return {}
      },
    },
    keys: {
      type: Object,
      default: () => {
        return {}
      },
    },
    link_row: {
      type: Object,
      default: () => {
        return {}
      },
    },
    selectedItems: {
      type: Array,
      default: () => {
        return []
      },
    },
  },
  data() {
    return {
      classRow: false,
    }
  },
  computed: {},
  methods: {
    rowClass(s) {
      if (s == true) {
        this.classRow = true
      }
    },
    deleteElem(data) {
      this.$emit('deleteElem', data)
    },
    viewElem(data) {
      // console.log(data)
      this.$emit('viewElem', data)
    },
    updateElem(data) {
      this.$emit('updateElem', data)
    },
    editElem(data) {
      this.$emit('editElem', data)
    },
    clickElem(data) {
      this.$emit('clickElem', data)
    },
    checkElem(data) {
      this.$emit('checkElem', data)
    },
    approveElem(data) {
      this.$emit('approveElem', data)
    },
    disapproveElem(data) {
      this.$emit('disapproveElem', data)
    },
    editNumber(object) {
      this.$emit('editNumber', object)
      // console.log(object)
    },
    actionCell(data) {
      this.$emit('actionCell', data)
    },
    saleModal(data) {
      this.$emit('saleModal', data)
    },
    linkParams() {
      const linkparams = {}
      if (this.link_row != {}) {
        for (const key in this.link_row.link_params) {
          if (
            this.link_row.link_params[key] !== 'id' &&
            this.link_row.link_params[key] !== 'store_id' &&
            this.link_row.link_params[key] !== 'vendor_id'
          ) {
            linkparams[key] = this.link_row.link_params[key]
          } else {
            linkparams[key] = this.row_data[this.link_row.link_params[key]]
          }
        }
        // console.log(linkparams)
      }
      return linkparams
    },
  },
  components: {
    vTableCell,
  },
  mounted() {
    // console.log(this.row_data)
  },
}
</script>

<style lang="scss">
// .img_abs{
//   img{
//     max-width: 100px;
//     max-height: 70px;
//   }
// }
.name {
  text-align: left;
}
.d-table__row-noactive .cell_value:not(.actions) {
  opacity: 0.3;
}
</style>
