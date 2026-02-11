<template>

  <router-link class="d-table-min__row"
  :to="{ name: keys.id.link_to, params: {id: this.$route.params.id, order_id: row_data.id}, props: keys.id.link_props }"
  >
  <div class="d-table-min__header">
      <div class="d-table-min__col-id">№ {{ row_data.id }} </div>
      <div class="d-table-min__col-status"><span :style="
              'color: #fff;background-color: #' +
              row_data.status_color
            ">{{ row_data.status_name }}</span>
      </div>
  </div>

    <v-table-cell
      v-for="(row, index) in keys"
      :key="index"
      :cell_data="row"
      :cell_key="index"
      :value="row_data"
      style="cursor: pointer"
    />
  </router-link>
  <slot name="add_data"></slot>

</template>

<script>
import vTableCell from './tableCell.vue'

export default {
  name: 'v-table-row',
  emits: [

  ],
  props: {

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

  },
  data() {
    return {
      classRow: false,
    }
  },
  computed: {},
  methods: {
    rowClass(s){
      if(s == true){
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
    actionCell(data){
      this.$emit('actionCell', data)
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
.d-table-min__header{
  display: flex;
  align-items: center;
  justify-content: start;
  gap: 16px;
  width: 100%;
  padding: 4px 0;
}
</style>
