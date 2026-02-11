<template>
  <div class="v-box-table">
    <div class="profile-content__title" v-if="title">
      <div class="text">
        <span class="title"
          >{{ title }} (<span v-if="total > -1">{{ total }}</span
          ><span v-else>0</span>)</span
        >
        <slot name="desc"></slot>
      </div>
      <slot name="button"></slot>
    </div>
    <div class="dart-row dart-align-items-center dart-mb-1" v-if="show_filter">
      <div class="d-col-xl-6 d-col-md-4" v-for="(ffilter, i) in filters" :key="i">
        <div class="form_input_group input_pl input-parent required" v-if="ffilter.type == 'text'">
          <FloatLabel>
            <InputText
              :id="i"
              :name="i"
              v-model="filter"
              @update:modelValue="setFilter('filter')"
            />
            <label for="username">{{ ffilter.placeholder }}</label>
          </FloatLabel>
        </div>
        <div class="dart-form-group" v-if="ffilter.type == 'select'">
          <!-- <label>{{ ffilter.name }}</label> -->
          <select
            :name="i"
            :id="'filter_' + i"
            class="dart-form-control"
            v-model="filtersdata[i]"
            @change="setFilter"
          >
            <option v-for="(opt, opt_i) in ffilter.values" :key="opt_i" :value="opt">
              {{ opt_i }}
            </option>
          </select>
        </div>
        <div class="dart-form-group" v-if="ffilter.type == 'dropdown'">
          <SelectInput
            v-model="filtersdata[i]"
            :options="ffilter.values"
            filter
            showClear
            :optionLabel="ffilter.optionLabel ? ffilter.optionLabel : 'name'"
            :optionValue="ffilter.optionValue ? ffilter.optionValue : 'id'"
            :placeholder="ffilter.placeholder"
            @change="setFilter"
          ></SelectInput>
        </div>
        <div class="dart-form-group" v-if="ffilter.type == 'number'">
          <InputNumber
            v-model="filtersdata[i]"
            :min="0"
            :max="100"
            showButtons
            buttonLayout="horizontal"
            :step="ffilter.step ? ffilter.step : 1"
            :optionLabel="ffilter.optionLabel ? ffilter.optionLabel : 'name'"
            :optionValue="ffilter.optionValue ? ffilter.optionValue : 'id'"
            :placeholder="ffilter.placeholder"
            @update:modelValue="setFilter"
          />
        </div>
        <div class="dart-form-group" v-if="ffilter.type == 'vv'">
          <AutoComplete
            v-model="filtersdata[i]"
            placeholder="Производитель"
            optionLabel="name"
            dataKey="id"
            :suggestions="filteredVendor"
            @complete="searchVendor"
            @change="setFilter"
          >
            <template #option="slotProps">
              <div class="flex align-options-center">
                <img
                  :alt="slotProps.option.name"
                  :src="site_url_prefix + slotProps.option.logo"
                  :class="`image mr-2`"
                  style="width: 30px"
                />
                <div>{{ slotProps.option.name }}</div>
              </div>
            </template>
          </AutoComplete>
        </div>
        <div class="dart-form-group" v-if="ffilter.type == 'range'">
          <Calendar
            v-model="filtersdata[i]"
            selectionMode="range"
            placeholder="Выберите диапазон дат"
            :manualInput="true"
            :maxDate="calendar.maxDate"
            showIcon
            @update:modelValue="setFilter"
          />
        </div>
        <div class="dart-form-group" v-if="ffilter.type == 'months_range'">
          <Calendar
            v-model="filtersdata[i]"
            selectionMode="range"
            placeholder="Выберите диапазон дат"
            view="month"
            :manualInput="true"
            :maxDate="calendar.maxDate"
            showIcon
            @update:modelValue="setFilter"
          />
        </div>
        <div class="dart-form-group" v-if="ffilter.type == 'tree'">
          <!-- <TreeSelect
            v-model="filtersdata[i]"
            appendTo="self"
            :options="ffilter.values"
            :maxSelectedLabels="3"
            selectionMode="single"
            :placeholder="ffilter.placeholder"
            class="w-full"
            :fluid="true"
            @select="setFilter"
          /> -->
          <TreeSelect
            v-model="filtersdata[i]"
            :multiple="true"
            :options="ffilter.values"
            :placeholder="ffilter.placeholder"
            valueFormat="id"
            :limit="1"
            :limitText="(count) => `и еще ${count}`"
            @select="setFilter"
            @deselect="setFilter"
          />
        </div>
        <div class="dart-form-group" v-if="ffilter.type == 'checkbox'">
          <div class="flex align-items-center gap-1">
            <Checkbox
              v-model="filtersdata[i]"
              :inputId="'input' + i"
              :name="i"
              value="1"
              @change="setFilter"
            />
            <label :for="'input' + i" class="ml-2 mb-0">
              {{ ffilter.placeholder }}
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="v-table__widgets">
      <slot name="widgets"></slot>
    </div>
    <div class="d-table__wrapper" v-if="total != 0">


        <div v-if="total != -1" class="clients__card-container">
          <!-- v-for="row in items_data" -->
          <v-table-row
            v-for="row in localItems"
            :key="row.id"
            :row_data="row"
            :keys="table_data"
            :editMode="editMode"
            :selectedItems="this.selectedItems"
            @deleteElem="deleteElem"
            @updateElem="updateElem"
            @viewElem="viewElem"
            @clickElem="clickElem"
            @checkElem="checkElem"
            @editElem="editElem"
            @approveElem="approveElem"
            @disapproveElem="disapproveElem"
            @editNumber="editNumber"
            @actionCell="actionCell"
            :link_row="link_row"
          />
        </div>
        <div v-else>
          <div v-for="n in 10" :key="n" class="clients__card-container">
            <div v-for="(row, index) in table_data" :key="index">
              <Skeleton class="mb-2"></Skeleton>
            </div>
          </div>
        </div>

      <div class="d-pagination-wrap" v-if="pagesCount > 1">
        <paginate
          :page-count="pagesCount"
          :click-handler="pagClickCallback"
          :prev-text="'Пред'"
          :next-text="'След'"
          :container-class="'d-pagination d-table__footer-right-pagination'"
          :page-class="'d-pagination__item'"
          :active-class="'d-pagination__item--active'"
          :initialPage="this.page"
          :forcePage="this.page"
        >
        </paginate>
      </div>
    </div>
    <div class="profile-products__products" v-else>
      <div class="dart-alert dart-alert-info">Ничего не найдено</div>
    </div>
  </div>
</template>

<script>
import { toRaw } from 'vue'
import { mapActions, mapGetters } from 'vuex'
import vTableRow from './tableRow.vue'
// import vTableFilter from './v-table-filter'
import Paginate from 'vuejs-paginate-next'
import Calendar from 'primevue/calendar'
import InputText from 'primevue/inputtext'
import FloatLabel from 'primevue/floatlabel'
// import the component
import TreeSelect from '@zanmato/vue3-treeselect'
// import the styles
import '@zanmato/vue3-treeselect/dist/vue3-treeselect.min.css'
import SelectInput from 'primevue/select'
import AutoComplete from 'primevue/autocomplete'
import Checkbox from 'primevue/checkbox'
import InputNumber from 'primevue/inputnumber'
import Skeleton from 'primevue/skeleton'

export default {
  name: 'v-table',
  emits: [
    'deleteElem',
    'viewElem',
    'updateElem',
    'editElem',
    'clickElem',
    'filter',
    'sort',
    'paginate',
    'setAllCheck',
    'checkElem',
    'approveElem',
    'disapproveElem',
    'editNumber',
    'actionCell',
  ],
  components: {
    vTableRow,
    // vTableFilter,
    Paginate,
    TreeSelect,
    Calendar,
    AutoComplete,
    SelectInput,
    InputNumber,
    Skeleton,
    Checkbox,
    InputText,
    FloatLabel,
  },
  props: {
    editMode: {
      type: Boolean,
      default: false,
    },
    items_data: {
      type: Array,
      default: () => [],
    },
    filters: {
      type: Object,
      default: () => {
        return {}
      },
    },
    table_data: {
      type: Object,
      default: () => {
        return {}
      },
    },
    title: {
      type: String,
      default: null,
    },
    total: {
      type: Number,
      default: -1,
    },
    pagination_items_per_page: {
      type: Number,
      default: 5,
    },
    pagination_offset: {
      type: Number,
      default: 0,
    },
    page: {
      type: Number,
      default: 1,
    },
    show_filter: {
      type: Boolean,
      default: true,
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
      localItems: [], // копия items_data
      filter: '',
      filtersdata: {},
      sort: {},
      per_page: this.pagination_items_per_page,
      loading: false,
      calendar: {
        maxDate: null,
      },
      filteredVendor: null,
      all_check: false,
    }
  },
  computed: {
    ...mapGetters({
      vendors: 'addition/vendors',
    }),
    pagesCount() {
      let pages = Math.ceil(this.total / this.per_page)
      if (pages === 0) {
        pages = 1
      }
      return pages
    },
    // all_check: {
    // 	get() {
    // 	if (!this.localItems.length) return false;
    // 	return this.localItems.every(item => this.selectedItems.includes(item.id));
    // 	},
    // 	set(val) {
    // 	const currentPageIds = this.localItems.map(item => item.id);

    // 	if (val) {
    // 		// Добавляем ID текущей страницы к выбранным
    // 		const newSelected = [...new Set([...this.selectedItems, ...currentPageIds])];
    // 		this.selectedItems = newSelected;
    // 	} else {
    // 		// Удаляем ID текущей страницы из выбранных
    // 		this.selectedItems = this.selectedItems.filter(id => !currentPageIds.includes(id));
    // 	}

    // 	this.$emit("checkElem", this.selectedItems);
    // 	}
    // },
    allChecked() {
      if (!this.localItems.length) return false
      return this.localItems.every((item) => this.selectedItems.includes(item.id))
    },
  },
  methods: {
    ...mapActions({
      getVendors: 'addition/getVendors',
    }),
    checkElem(data) {
      this.$emit('checkElem', data)
    },
    viewElem(data) {
      this.$emit('viewElem', data)
    },
    toggleAllChecked(checked) {
      // console.log(this.items_data)
      if (checked) {
        let newSelected = Object.values(this.selectedItems)
        console.log(newSelected)
        for (let i = 0; i < Object.keys(this.items_data).length; i++) {
          // console.log(this.items_data[Object.keys(this.items_data)[i]].id)
          newSelected.push(this.items_data[Object.keys(this.items_data)[i]].id)
        }
        this.$emit('checkElem', newSelected)
      } else {
        let newSelected = this.selectedItems
        for (let i = 0; i < Object.keys(this.items_data).length; i++) {
          newSelected = newSelected.filter(
            (item) => item !== this.items_data[Object.keys(this.items_data)[i]].id,
          )
        }
        this.$emit('checkElem', newSelected)
      }
    },
    // 	const currentPageIds = this.localItems.map(item => item.id);

    // 	if (checked) {
    // 	this.selectedItems = [...new Set([...this.selectedItems, ...currentPageIds])];
    // 	} else {
    // 	this.selectedItems = this.selectedItems.filter(id => !currentPageIds.includes(id));
    // 	}

    // 	this.$emit("checkElem", this.selectedItems);

    // 	// Обновляем состояние чекбоксов на текущей странице
    // 	this.localItems = this.localItems.map(item => ({
    // 	...item,
    // 	checked: checked
    // 	}));
    // },
    // setAllCheck(event) {
    // 	this.$emit("setAllCheck", event);
    // },
    // setAllCheck(event) {
    // 	// this.all_check = event;

    // 	if (!Array.isArray(this.items_data)) return;

    // 	this.items_data.forEach(item => {
    // 		item.checked = this.all_check;
    // 	});

    // 	this.selectedItems = this.all_check
    // 		? this.items_data.map(item => ({ ...item }))
    // 		: [];

    // 	this.$emit("checkElem", this.selectedItems.map(item => item.id));

    // 	// this.selectedItems = !this.all_check
    // 	// 	? this.items_data.map(item => ({ ...item }))
    // 	// 	: [];
    // 	// console.log(this.selectedItems)
    // 	// this.$emit("checkElem", this.selectedItems.map(item => item.id));
    // },
    deleteElem(data) {
      this.$emit('deleteElem', data)
    },
    clickElem(data) {
      this.$emit('clickElem', data)
    },
    updateElem(data) {
      this.$emit('updateElem', data)
    },
    editElem(data) {
      this.$emit('editElem', data)
    },
    approveElem(data) {
      this.$emit('approveElem', data)
    },
    disapproveElem(data) {
      this.$emit('disapproveElem', data)
    },
    editNumber(object) {
      this.$emit('editNumber', object)
    },
    actionCell(data) {
      this.$emit('actionCell', data)
    },
    // filterglobalTable(checked) {
    // 	if (checked) {
    // 		this.selectedItems = [...new Set([...this.selectedItems, ...this.products.ids])];
    // 	} else {
    // 		const currentPageIds = this.localItems.map(item => item.id);
    // 		this.selectedItems = this.selectedItems.filter(id =>
    // 		!this.products.ids.includes(id) || currentPageIds.includes(id)
    // 		);
    // 	}

    // 	this.$emit("checkElem", [...this.selectedItems]);

    // 	// Обновляем чекбоксы на текущей странице
    // 	this.localItems = this.localItems.map(item => ({
    // 		...item,
    // 		checked: checked || this.selectedItems.includes(item.id)
    // 	}));
    // },
    setFilter(type = '0') {
      // console.log(type)
      if (type === 'filter') {
        if (this.filter.length >= 3 || this.filter.length === 0) {
          setTimeout(() => {
            this.$emit('filter', {
              filter: this.filter,
              filtersdata: toRaw(this.filtersdata),
              sort: this.sort,
              page: 1,
              perpage: this.pagination_items_per_page,
            })
          })
        }
      } else {
        setTimeout(() => {
          this.$emit('filter', {
            filter: this.filter,
            filtersdata: toRaw(this.filtersdata),
            sort: this.sort,
            page: 1,
            perpage: this.pagination_items_per_page,
          })
        }, 500)
      }
    },
    sorting(key) {
      if (Object.prototype.hasOwnProperty.call(this.sort, key)) {
        if (this.sort[key].dir == 'ASC') {
          this.sort[key] = {
            dir: 'DESC',
            sort_desc: true,
            active: true,
          }
        } else {
          this.sort = {}
        }
      } else {
        this.sort = {}
        this.sort[key] = {
          dir: 'ASC',
          sort_asc: true,
          active: true,
        }
      }
      this.$emit('sort', {
        filter: this.filter,
        filtersdata: toRaw(this.filtersdata),
        sort: toRaw(this.sort),
        page: 1,
        perpage: this.pagination_items_per_page,
      })
    },
    pagClickCallback(pageNum) {
      this.$emit('paginate', {
        filter: this.filter,
        filtersdata: toRaw(this.filtersdata),
        sort: this.sort,
        page: pageNum,
        perpage: this.pagination_items_per_page,
      })

      const el = document.querySelector('.profile-table tbody')
      if (el) {
        el.scrollIntoView({ behavior: 'smooth' })
      }
    },
    searchVendor(event) {
      if (!event.query.trim().length > 2) {
        this.filteredVendors = [...this.vendors]
      } else {
        const data = {
          search: event.query.trim(),
        }
        this.filteredVendors = this.getVendors(data)
      }
    },
  },
  mounted() {
    const data = {
      search: '',
    }
    this.getVendors(data).then((this.filteredVendor = this.vendors))
    if (Array.isArray(this.items_data)) {
      this.items_data.forEach((item) => {
        if (typeof item.checked === 'undefined') {
          item.checked = false
        }
      })
    }
  },
  created() {
    // console.log(this.filters)
    if (typeof this.filters.range !== 'undefined') {
      if (this.filters.range.range !== 'all') {
        const currDate = Date.now()
        // console.log('Unix time stamp of current date', currDate)
        this.calendar.maxDate = new Date(currDate)
        // console.log(this.calendar.maxDate.getFullYear())
      }
    }
  },
  watch: {
    vendors: function (newVal) {
      // console.log(newVal)
      this.filteredVendor = toRaw(newVal)
      // console.log(this.filteredVendor)
    },
    editMode: function (newVal) {
      if (!newVal) {
        this.all_check = false
        this.$emit('setAllCheck', [this.all_check])
      }
    },
    items_data: {
      handler(newVal) {
        this.localItems = newVal
      },
      immediate: true,
    },
    // all_check(val) {
    // 	if (!Array.isArray(this.localItems)) return;

    // 	this.localItems.forEach(item => {
    // 		if (item.checked !== val) item.checked = val;
    // 	});

    // 	this.selectedItems = val ? [...this.localItems] : [];
    // 	this.$emit("checkElem", this.selectedItems.map(item => item.id));
    // },
    filters: {
      handler(newVal, oldVal) {
        // console.log('Filters updated:', newVal, oldVal);
        if (newVal.store && newVal.store.values == undefined) {
          this.org_get_stores_from_api({
            action: 'get/stores',
            id: this.$route.params.id,
          }).then((res) => {
            const stores = res.data.data

            let storesall = []
            for (let i = 0; i < stores?.items?.length; i++) {
              storesall.push({ name: stores.items[i].name, id: stores.items[i].id })
            }

            // this.filters.store.values = storesall
          })
        }
        if (newVal !== oldVal) {
          // Выполните нужные действия
        }
      },
      deep: true,
      immediate: true, // Сразу выполнить при создании компонента
    },
    filtersdata: function (newVal) {
      console.log(newVal)
    },
    // allChecked(val) {
    // 	if (!Array.isArray(this.localItems)) return;

    // 	this.localItems.forEach(item => {
    // 	item.checked = val;
    // 	});

    // 	this.$emit("checkElem", val ? this.localItems.map(item => item.id) : []);
    // }
  },
}
</script>

<style lang="scss">
.profile-content__title {
  display: flex;
  justify-content: space-between;
  padding-bottom: 12px;
  .text {
    color: #282828;
    font-size: 18px;
  }
}
.d-pagination-wrap {
  padding: 20px 0;
  display: flex;
  align-items: center;
  justify-content: center;
  .d-pagination {
    gap: 0 5px;
    .page-item.disabled {
      opacity: 0.5;
      a {
        cursor: not-allowed;
      }
    }
    .d-pagination__item {
      a {
        display: flex;
        flex-shrink: 0;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        line-height: 100%;
        text-align: center;
      }
    }
  }
}
thead {
  position: sticky;
  top: 0;
  z-index: 1;
}
tbody {
  .d-table__row:first-child::after {
    content: '';
    background-color: #75757575;
    position: absolute;
    bottom: 0;
    left: 50%;
    translate: -50% 0;
    width: calc(100% - var(--d-table-first-col-padding) * 2);
    height: 1px;
  }
  .d-table__row:first-child .d-table__head-col::before,
  .d-table__row:first-child .d-table__col::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    translate: 0 -50%;
    width: 0.5px;
    height: var(--d-table-col-divider-height);
  }
  .d-table__row:first-child .d-table__head-col:not(:first-child)::before,
  .d-table__row:first-child .d-table__col:not(:first-child)::before {
    background-color: #75757575;
  }
  .d-table__row:not(:last-child, :first-child)::after {
    content: '';
    background-color: #75757575;
  }
  &:not(:first-child) {
    .d-table__head-col,
    .d-table__col {
      &:not(:first-child) {
        &::before {
          background-color: #75757575;
        }
      }
    }
  }
}
.d-table__head {
  .d-table__row:first-child::after {
    content: '';
    background-color: #75757575;
    position: absolute;
    bottom: 0;
    left: 50%;
    translate: -50% 0;
    width: calc(100% - var(--d-table-first-col-padding) * 2);
    height: 1px;
  }
  .d-table__row:first-child .d-table__head-col::before,
  .d-table__row:first-child .d-table__col::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    translate: 0 -50%;
    width: 0.5px;
    height: var(--d-table-col-divider-height);
  }
  .d-table__row:first-child .d-table__head-col:not(:first-child)::before,
  .d-table__row:first-child .d-table__col:not(:first-child)::before {
    background-color: #75757575;
  }
  .d-table__row:not(:last-child, :first-child)::after {
    content: '';
    background-color: #75757575;
  }
  &:not(:first-child) {
    .d-table__head-col,
    .d-table__col {
      &:not(:first-child) {
        &::before {
          background-color: #75757575;
        }
      }
    }
  }
}
.clients__card-container .dart-row {
    margin-right: 0px;
    margin-left: 0px;
}
</style>
