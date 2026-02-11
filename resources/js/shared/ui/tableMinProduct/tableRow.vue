<template>

<div class="d-table-min-product__row">
  <div class="d-table-min-product__header">
      <div class="d-table-min-product__col-image">
        <div class="img_abs" v-if="row_data.image">
          <img :src="row_data.image" alt="" />
        </div>
        <div class="img_abs" v-else>
          <img :src="site_url_prefix + 'assets/files/img/nopic.png'" alt="" />
        </div>
      </div>
  </div>
  <div class="d-table-min-product__content">
    <div class="d-table-min-product__col-name">
      <div class="d-table-min-product__cell-label">
        {{ keys['name'].label }}
      </div>
      <div class="d-table-min-product__cell-value">
        {{ row_data.name }}
      </div>
    </div>
    <div class="d-table-min-product__col-all">
      <v-table-cell
        v-for="(row, index) in keys"
        :key="index"
        :cell_data="row"
        :cell_key="index"
        :value="row_data"
        @saleModal="saleModal"
      />
    </div>
  </div>
</div>
  <slot name="add_data"></slot>

</template>

<script>
import vTableCell from './tableCell.vue'

export default {
  name: 'v-table-row',
  emits: [
    "saleModal"
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
    saleModal(data){
      this.$emit('saleModal', data)
    },
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
.d-table-min-product__row{
  width: 100%;
  height: auto;
  background: #FBFBFB;
  box-shadow: 0px 4px 13.4px -5px rgba(0, 0, 0, 0.26);
  border-radius: 6px;
  padding: 8px;
  display: flex;
  align-items: center;
  gap: 16px;
}
.d-table-min-product__content{
  display: flex;
  flex-direction: column;
  align-items: start;
  justify-content: center;
  gap: 9px;
  width: 100%;
}
.d-table-min-product__col-name{
  display: flex;
  flex-direction: column;
  align-items: start;
  justify-content: center;
  gap: 4px;
}
.d-table-min-product__cell-label{
  font-weight: 400;
  font-size: 7px;
  line-height: 9px;
  color: #757575;
}
.d-table-min-product__cell-value{
  font-weight: 500;
  font-size: 8px;
  line-height: 10px;
  color: #282828;
}
.d-table-min-product__col-all{
  display: flex;
  align-items: start;
  justify-content: space-between;
  width: 100%;
}
.d-table-min-product__col-image{
  width: 54px;
  height: 55px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}
.d-table-min-product__col-simple{
  min-width: 45px;
  display: flex;
  flex-direction: column;
  align-items: start;
  justify-content: start;
  gap: 4px;
}
@media (width <= 600px) {
  .d-table-min-product__body{
    gap: 32px !important;
  }
  .v-table-min-product{
    width: calc(100% + 88px);
    margin-left: - 44px;
  }
  .d-table-min-product__row,.d-table-min-product__col-all{
    flex-direction: column;
  }
  .d-table-min-product__row{
    padding: 16px 24px;
    box-shadow: none;
    background-color: #fff;
    border-radius: 10px;
    gap: 24px;
  }
  .d-table-min-product__col-image, .d-table-min-product__col-image img{
    width: auto;
    height: 198px;
  }
  .d-table-min-product__content{
    gap: 24px;
  }
  .d-table-min-product__col-all{
    gap: 15px;
  }
  .d-table-min-product__col-name, .d-table-min-product__col-simple {
    gap: 7px;
  }
  .d-table-min-product__cell-label{
    font-size: 14px;
    line-height: 16px;
  }
  .d-table-min-product__cell-value{
    font-size: 16px;
    line-height: 21px;

  }
}
</style>
