<template>
  <div class="lk-staff__card-contact-container" :class="cell_data.class">

    <div class="cell_value" v-if="cell_data.type == 'text'">
      <p class="lk-staff__card-contact-label" v-if="cell_data.label">{{cell_data.label}}</p>
      <a :href="cell_data.link + value[cell_key].replace(/\D/g, '')" v-if="cell_data.link && cell_data.link == 'tel:'">
        <i class="lk-staff__card-contact-icon" :class="cell_data.icon" v-if="cell_data.icon"></i>
        <span class="lk-staff__card-contact-value">{{ value[cell_key] }}</span>
      </a>
      <a :href="cell_data.link + value[cell_key]" v-else-if="cell_data.link && cell_data.link != 'tel:'">
        <i class="lk-staff__card-contact-icon" :class="cell_data.icon" v-if="cell_data.icon"></i>
        <span class="lk-staff__card-contact-value">{{ value[cell_key] }}</span>
      </a>
      <div v-else>
        <i class="lk-staff__card-contact-icon" :class="cell_data.icon" v-if="cell_data.icon"></i>
        <span class="lk-staff__card-contact-value">{{ value[cell_key] }}</span>
      </div>
    </div>

    <div
      class="cell_value"
      :class="cell_key == 'actions'"
      v-else-if="cell_data.type == 'actions'"
    >
      <span class="p-buttonset">
        <Button
          class="lk-staff__card-actions-button"
          :title="row.label"
          :label="row.label"
          :icon="row.icon"
          v-for="(row, index) in blank.available"
          :key="index"
          severity="secondary"
          text
          @click="actionElem(index)"
        >
          <i :class="row.icon"></i>
        </Button>
      </span>
    </div>



  </div>

</template>

<script>
import Button from 'primevue/button'
import Checkbox from 'primevue/checkbox'
import InputNumber from 'primevue/inputnumber'
import Chart from 'primevue/chart'

export default {
  name: 'tableCell',
  emits: [
    'deleteElem',
    'updateElem',
    'editElem',
    'clickElem',
    'viewElem',
    'checkElem',
    'approveElem',
    'disapproveElem',
    'editNumber',
    'update:selectedItems',
    'actionCell',
  ],
  props: {
    editMode: {
      type: Boolean,
      default: false,
    },
    cell_data: {
      type: Object,
      default: () => {
        return {}
      },
    },
    cell_key: {
      type: String,
      default: null,
    },
    value: {
      type: Object,
      default: () => {
        return {}
      },
    },
    link_params: {
      type: Object,
      default: () => {
        return {}
      },
    },
    selectedItems: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      blank: {},
      numbers: {},
      chart_options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
            display: false,
          },
          title: {
            display: false,
            text: 'График',
          },
        },
      },
    }
  },
  computed: {
    isChecked: {
      get() {
        return this.selectedItems.includes(this.value.id)
      },
      set(value) {
        console.log(value)
        // Пустой сеттер, так как изменения обрабатываются в toggleSelection
      },
    },
    linkParams() {
      const linkparams = {}
      if (this.cell_data.type === 'link') {
        for (const key in this.cell_data.link_params) {
          if (
            this.cell_data.link_params[key] !== 'id' &&
            this.cell_data.link_params[key] !== 'store_id' &&
            this.cell_data.link_params[key] !== 'vendor_id' &&
            this.cell_data.link_params[key] !== 'pagetitle'
          ) {
            linkparams[key] = this.cell_data.link_params[key]
          } else {
            linkparams[key] = this.value[this.cell_data.link_params[key]]
          }
        }
      }
      return linkparams
    },
  },
  methods: {
    toggleSelection(id) {
      console.log(id)
      if (this.selectedItems.includes(id)) {
        // console.log('da')
        // console.log(this.selectedItems.filter(item => item !== id))
        this.$emit(
          'checkElem',
          this.selectedItems.filter((item) => item !== id),
        )
        // this.selectedItems = this.selectedItems.filter(item => item !== id);
      } else {
        // console.log('net')
        // this.selectedItems.push(id)
      }
      // const newSelectedItems = [...this.selectedItems]
      // const itemId = this.value.id
      // const index = newSelectedItems.indexOf(itemId)

      // if (index === -1) {
      //   // Добавляем элемент
      //   newSelectedItems.push(itemId)
      // } else {
      //   // Удаляем элемент
      //   newSelectedItems.splice(index, 1)
      // }

      // // Эмитим событие для обновления selectedItems в родительском компоненте
      // this.$emit('update:selectedItems', newSelectedItems)
    },
    actionElem(action) {
      if (action === 'delete') {
        this.$emit('deleteElem', this.value)
      }
      if (action === 'update') {
        this.$emit('updateElem', this.value)
      }
      if (action === 'edit') {
        this.$emit('editElem', this.value)
      }
      if (action === 'click') {
        this.$emit('clickElem', this.value)
      }
      if (action === 'approve') {
        this.$emit('approveElem', this.value)
      }
      if (action === 'disapprove') {
        this.$emit('disapproveElem', this.value)
      }
      if (action === 'view') {
        this.$emit('viewElem', this.value)
      }
    },
    editValue(number, name) {
      this.$emit('editNumber', { value: number, id: this.value.id, name: name })
    },
    actionCell(id) {
      this.$emit('actionCell', id)
    },
  },
  components: {
    Button,
    InputNumber,
    Checkbox,
    Chart,
  },
  mounted() {
    this.blank = this.cell_data
    if (this.blank.type === 'actions') {
      for (const key in this.blank.available) {
        if (
          Object.prototype.hasOwnProperty.call(this.blank.available[key], 'link') &&
          Object.prototype.hasOwnProperty.call(this.blank.available[key], 'link_values')
        ) {
          if (this.blank.available[key].link && this.blank.available[key].link_values) {
            const link = this.blank.available[key].link
            const values = this.blank.available[key].link_values
            if (!values.includes(Number(this.value[link]))) {
              delete this.blank.available[key]
            }
          }
        }
      }
    }
    if (this.cell_data.type === 'number') {
      this.numbers[this.cell_key] = this.value[this.cell_key]
    }
  },
  unmounted() {
    this.numbers[this.cell_key] = this.value[this.cell_key]
  },
}
</script>

<style lang="scss" scoped>
.kenostButton {
  padding: 8px !important;
  background: #f8f8f8 !important;
  box-shadow: 0px 1px 5px 0px #00000033;
  box-shadow: 0px 3px 1px 0px #0000001f;
  box-shadow: 0px 2px 2px 0px #00000024;
  color: #adadad;
}
.kenostButton + .kenostButton {
  margin-left: 8px;
}
.img_abs {
  img {
    max-width: 75px;
    max-height: 70px;
    object-fit: contain;
  }
}
.p-button {
  color: #343434;
  background: transparent;
  border-color: transparent;
  &:enabled:hover {
    background: transparent;
    border-color: transparent;
    color: #343434;
  }
  &:hover {
    color: #343434;
  }
}
.cell__error {
  color: #f00;
}
.cell__success {
  color: #0f0;
}
.name {
  text-align: left;
}
.cell_description {
  display: block;
  padding-top: 5px;
  font-size: 14px;
  letter-spacing: 0.5px;
  font-weight: bold;
  color: #666666;
}
.cell_centeralign {
  text-align: center;
}
.cell__error-active {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #ff715b;
  border-radius: 50%;
  font-size: 8px;
  font-weight: 600;
  width: 18px;
  height: 18px;
  margin: 0 auto;
}
.cell__success-active {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #cdf0a9;
  border-radius: 50%;
  font-size: 8px;
  width: 18px;
  height: 18px;
  margin: 0 auto;
}
.table_link {
  cursor: pointer;
}

.lk-staff__card-contact-container{
  position: relative;
}
.clients__card-container .lk-staff__card-contact-container{
  padding: 0 8px;
}
.clients__card-container .lk-staff__card-contact-container:first-child{
  padding-left: 0;
}
.clients__card-container .lk-staff__card-contact-container:last-child{
  padding-right: 0;
}
.lk-staff__card-contact-label{
  padding-bottom: 8px;
}
.lk-staff__card-contact-icon{
  margin-right: 8px;;
}
.lk-staff__card-contact-container:not(:first-child):before{
    content: ' ';
    position: absolute;
    top:calc(50% - 12.5px);
    left:0;
    width: 1px !important;
    height: 20px;
    background-color: #75757575;
}
</style>
