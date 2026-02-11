<template>
  <td class="d-table__col">
    <div class="cell_value" v-if="cell_data.type == 'image'" :class="cell_data.class">
      <div class="img_abs" v-if="value[cell_key]">
        <img v-if="cell_data.baseurl" :src="value[cell_key]" alt="" />
        <img v-if="!cell_data.baseurl" :src="value[cell_key]" alt="" />
      </div>
      <div class="img_abs" v-else>
        <img :src="site_url_prefix + 'assets/files/img/nopic.png'" alt="" />
      </div>
    </div>
    <div
      class="cell_value"
      v-else-if="cell_data.type == 'editmode' && editMode"
      :class="cell_data.class"
    >
      <Checkbox v-model="isChecked" :binary="true" @change="toggleSelection(value.id)" />
    </div>
    <div class="cell_value" v-else-if="cell_data.type == 'text'" :class="cell_data.class">
      {{ value[cell_key] }}
      <div v-if="cell_data.description" class="cell_description">
        <span v-if="cell_data.description.type == 'field'">
          {{ value[cell_data.description.key] }}
        </span>
        <span v-else-if="cell_data.description.type == 'text'">
          {{ value[cell_key].description.text }}
        </span>
      </div>
    </div>
    <div class="cell_value" v-else-if="cell_data.type == 'html'" :class="cell_data.class">
      <div v-html="value[cell_key]"></div>
    </div>
    <div class="cell_value" v-else-if="cell_data.type == 'prepare-html'" :class="cell_data.class">
      <div class="d-table-html" :class="{'d-table-html-text' : value[cell_key]}"><p class="cell_data-label" v-if="value[cell_key]">{{cell_data.label}}:</p>{{ prepareHtml(value[cell_key]) }} </div>
    </div>
    <div class="cell_value" v-else-if="cell_data.type == 'gist'" :class="cell_data.class">
      <Chart
        type="line"
        :data="value[cell_key]"
        :options="chart_options"
        class="w-full md:w-5rem"
      />
    </div>
    <div class="cell_value" v-else-if="cell_data.type == 'boolean'" :class="cell_data.class">
      <div v-if="value[cell_key] == 0">
        <span class="cell__error" v-if="cell_data.calc == 'positive'">Нет</span>
        <span class="cell__error" v-else>Нет</span>
      </div>
      <div v-else>
        <span class="cell__error" v-if="cell_data.calc == 'negative'">Да</span>
        <span class="cell__success" v-else>Да</span>
      </div>
    </div>
    <div class="cell_value" v-else-if="cell_data.type == 'boolean_active'" :class="cell_data.class">
      <div v-if="value[cell_key] == 0">
        <span class="cell__error-active" v-if="cell_data.calc == 'positive'"
          ><i class="d-icon-minus"></i
        ></span>
        <span class="cell__error-active" v-else><i class="d-icon-minus"></i></span>
      </div>
      <div v-else>
        <span class="cell__success-active" v-if="cell_data.calc == 'negative'"
          ><i class="d-icon-check"></i
        ></span>
        <span class="cell__success-active" v-else><i class="d-icon-check"></i></span>
      </div>
    </div>
    <div
      class="cell_value"
      :class="cell_key == 'name' ? 'name ' + cell_data.class : cell_data.class"
      v-else-if="cell_data.type == 'link' && !cell_data.items && !cell_data.items_incl_img"
    >
      <router-link
        :to="{ name: cell_data.link_to, params: linkParams, props: cell_data.link_props }"
      >
        {{ value[cell_key] }}
        <div v-if="cell_data.description" class="cell_description">
          <span v-if="cell_data.description.type == 'field'">
            {{ value[cell_data.description.key] }}
          </span>
          <span v-else-if="cell_data.description.type == 'text'">
            {{ value[cell_key].description.text }}
          </span>
        </div>
      </router-link>
    </div>
    <div
      class="cell_value"
      :class="cell_data.class ? cell_data.class + ' link_onclick' : ' link_onclick'"
      v-else-if="cell_data.type == 'link_onclick'"
      @click.prevent="actionCell(value[cell_data.id])"
    >
      {{ value[cell_key] }}
      <div v-if="cell_data.description" class="cell_description">
        <span v-if="cell_data.description.type == 'field'">
          {{ value[cell_data.description.key] }}
        </span>
        <span v-else-if="cell_data.description.type == 'text'">
          {{ value[cell_key].description.text }}
        </span>
      </div>
    </div>
    <div
      class="cell_value"
      v-if="cell_data.type == 'link' && cell_data.items_incl_img"
      :class="cell_key == 'name' ? 'name ' + cell_data.class : cell_data.class"
    >
      <router-link
        :to="{ name: cell_data.link_to, params: linkParams, props: cell_data.link_props }"
      >
        <div class="d-table2__info">
          <div class="d-table2__info-header">
            <div class="d-table2__info-header-image-wrapper">
              <img
                :src="value[cell_data.items_incl_img[0]]"
                class="cell-flex-d-table2__info-header-image-item"
              />
            </div>

            <p class="d-table2__info-header-title">{{ value[cell_data.items_incl_img[1]] }}</p>
          </div>
          <div class="d-table2__info-address">
            <i class="d-icon-location d-table2__info-address-icon"></i
            ><span>{{ value[cell_data.items_incl_img[2]] }}</span>
          </div>
        </div>
      </router-link>
    </div>
    <div
      class="cell_value"
      :class="cell_key == 'name' ? 'name ' + cell_data.class : cell_data.class"
      v-else-if="cell_data.type == 'sales'"
    >
      <div class="order-product-actions" @click.prevent="this.$emit('saleModal', value)" v-if="countSales(value[cell_key]) > 0">
          <div>{{ countSales(value[cell_key]) }}</div><div>Смотреть</div>
      </div>

    </div>
    <div
      class="cell_value"
      v-if="cell_data.type == 'link' && cell_data.items"
      :class="cell_key == 'name' ? 'name ' + cell_data.class : cell_data.class"
    >
      <router-link
        :to="{ name: cell_data.link_to, params: linkParams, props: cell_data.link_props }"
      >
        <div v-for="item in cell_data.items" :key="item" class="multyitem_cell">
          <span v-if="value[item] && item.includes('inn')"
            >ИНН: {{ value[item] ? value[item] : '-' }}</span
          >
          <span v-if="value[item] && !item.includes('inn')" class="cell_value-inn">{{
            value[item]
          }}</span>
        </div>
      </router-link>
    </div>
    <div
      class="cell_value"
      :class="cell_key == 'name' ? 'name ' + cell_data.class : cell_data.class"
      v-else-if="cell_data.type == 'clickevent'"
    >
      <a href="#" @click.prevent="actionElem('click')">
        {{ value[cell_key] }}
      </a>
    </div>
    <div
      class="cell_value"
      :class="cell_key == 'name' ? 'name ' + cell_data.class : cell_data.class"
      v-else-if="cell_data.type == 'downloadhref'"
    >
      <a :href="value[cell_key]" download target="_blank" v-if="value[cell_key]"> Скачать </a>
      <span v-else>-</span>
    </div>
    <div
      class="cell_value text-center"
      :class="cell_key == 'cell_status' ? 'cell_status' + cell_data.class : cell_data.class"
      v-else-if="cell_data.type == 'status'"
    >
      <div class="cell--status"
        :style="
          'color: #fff;background-color: #' +
          value.status_color
        "
      >
        {{ value['status_name'] }}
  </div>
    </div>
    <div
      class="cell_value"
      :class="cell_key == 'actions' ? 'actions ' + cell_data.class : cell_data.class"
      v-else-if="cell_data.type == 'actions'"
    >
      <span class="p-buttonset">
        <Button
          class="kenostButton std-icon__wrapper"
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
    <div
      class="cell_value"
      :class="cell_key == 'actions_order' ? 'actions_order ' + cell_data.class : cell_data.class"
      v-else-if="cell_data.type == 'actions_order'"
    >
      <span class="p-buttonset">
        <Button
          class="kenostButton std-icon__wrapper"
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
    <div class="cell_value" v-else-if="cell_data.type == 'number'" :class="cell_data.class">
      <InputNumber
        v-model="numbers[cell_key]"
        :inputId="'input_' + cell_key"
        incrementButtonIcon="pi pi-plus"
        decrementButtonIcon="pi pi-minus"
        @update:modelValue="editValue(numbers[cell_key], cell_key)"
      />
    </div>
  </td>
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
    'rowClass',
    'saleModal',
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
    prepareHtml(code){
      if(code){
        let new_string = code.replace(/<(.|\n)*?>/g, '')
        new_string = new_string.replace(/\&nbsp;/g, ' ')
        new_string = new_string.replace(/\n/g, '')
        if(new_string.length > 120){
          new_string = new_string.substring(0,120)+"..."
        }
        this.$emit('rowClass', true)
        return new_string
      }else{
        return ''
      }

    },
    countSales(sale){
      let count = 0
      for(var i in sale){
        if(sale[i].enabled == 1){
          count++
        }
      }
      return count
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
.p-buttonset {
  white-space: nowrap;
}
.d-table-html{
  width: 100%;
    position: relative;
    word-wrap: break-word;
    text-wrap: wrap;
    white-space: pre-wrap; /* css-3 */
    white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
    white-space: -pre-wrap; /* Opera 4-6 */
    white-space: -o-pre-wrap; /* Opera 7 */
    overflow-wrap: break-word;
    overflow: hidden;
}
.cell--status{
  font-size: 12px;
  line-height:14px;
  padding: 3px 9px;
  font-weight:600;
  border-radius: 41px;
}
.order-product-actions {
    display: flex;
    gap: 0;
    cursor: pointer;
    align-items: center;
    justify-content: center;
}
.order-product-actions div{
    font-weight: 600;
    font-size: 14px;
    line-height: 18px;
    color: #282828;
    background: #CDF0A9;
    border-radius: 4px;
    padding: 3px 5px;
}
.order-product-actions div:first-child{
    padding: 3px 8px;
}
@media (width <= 1536px) {
    .shipments .order-product-actions div {
        font-size: 12px;
    }
}
@media (width <= 1280px) {
    .shipments .order-product-actions div {
        font-size: 10px;
    }
}
@media (width <= 1024px) {
    .shipments .order-product-actions div {
        font-size: 8px;
    }
}
</style>
