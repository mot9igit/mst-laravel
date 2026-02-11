<template>
  <div>
    <div class="promotions__card-warehouse promotions__card-warehouse-header-container">
      <div class="promotions__card-value-container promotions__card-warehouse-header">
        <p
          class="promotions__card-value promotions__card-value--bold promotions__card-value--small promotions__card-block-title promotions__card-warehouse-title"
        >
          Товары
        </p>
        <span
          class="promotions__card-label promotions__card-label--big promotions__card-warehouse-label"
          >Загрузите список товаров и установите скидки, которые получит клиент при выполнении
          условий акции</span
        >
      </div>
      <form class="d-search d-search--alt promotions__card-warehouse-search hidden-600">
        <i class="d-icon-search-big d-search__icon promotions__card-warehouse-search-icon"></i>
        <input
          type="text"
          placeholder="Найти товар по наименованию или артикулу"
          class="d-search__field"
          v-model="search"
          @focus="suggestionsShow = true"
          @blur="unActivate()"
        />
        <button
          type="button"
          class="d-button d-button-primary d-button-primary-small box-shadow-none d-search__button"
        >
          <span class="hidden-800">Найти</span>
          <i class="d-icon-search-big visible-800"></i>
        </button>

        <ul class="d-search__suggestions" v-if="this.suggestionsShow">
          <li
            class="d-search__suggestion"
            v-for="suggestion in productsAvailable.products"
            :key="suggestion.id"
          >
            <div class="d-search__suggestion-card" @click="selectProduct(suggestion)">
              <img :src="suggestion.image" alt="" class="d-search__suggestion-card__img" />
              <div class="d-search__suggestion-card__content">
                <span class="d-search__suggestion-card__title">{{ suggestion.name }}</span>
                <span class="d-search__suggestion-card__article"
                  >арт. {{ suggestion.article }}</span
                >
              </div>
            </div>
          </li>
        </ul>
      </form>

      <button
        class="d-button d-button-secondary d-button-secondary-small d-button--sm-shadow promotions__card-warehouse-settings-choose"
        @click.prevent="openFileDialog()"
      >
        <i class="d-icon-upload2"></i>
        Загрузить товары
      </button>
    </div>
    <div class="d-table__wrapper promotions__card-products" v-if="productsSelected.total > 0">
      <table class="d-table">
        <!-- <table class="d-table hidden-1200"> -->
        <thead class="d-table__head">
          <tr class="d-table__row">
            <th class="d-table__head-col">
              <div class="flex-center">
                <Checkbox
                  @update:modelValue="checkAll"
                  v-model="this.checked_all"
                  :binary="true"
                  inputId="checked_all"
                  value="1"
                />
              </div>
            </th>
            <th class="d-table__head-col" style="width: 20%">Товар</th>
            <th class="d-table__head-col">РРЦ</th>
            <th class="d-table__head-col">Скидка</th>
            <th class="d-table__head-col">Тип ценообразования</th>
            <th class="d-table__head-col">Цена со скидкой за шт.</th>
            <th class="d-table__head-col">Минимальное количество</th>
            <th class="d-table__head-col">Кратность</th>
            <th class="d-table__head-col">
              <div class="flex-center">
                <i class="d-icon-trash d-table__icon"></i>
              </div>
            </th>
          </tr>
        </thead>
        <tbody class="d-table__body promotions__product-card">
          <tr class="d-table__row" v-for="product in productsSelected.products" :key="product.id">
            <td class="d-table__col">
              <div class="flex-center">
                <Checkbox v-model="this.table" :value="Number(product.id)" />
              </div>
            </td>
            <td class="d-table__col">
              <div class="product-table-card">
                <p class="product-table-card__title">
                  {{ product.name }}
                </p>
                <p class="product-table-card__article">Арт: {{ product.article }}</p>
                <div class="d-badge d-badge--small">
                  <img
                    :src="product.store_image"
                    alt=""
                    class="d-badge__img"
                    v-if="product.store_image"
                  />
                  {{ product.store }}
                </div>
              </div>
            </td>
            <td class="d-table__col">
              <div class="d-table__col-inner">
                <p
                  class="promotions__card-text promotions__card-text--bold product-table-card__value"
                >
                  {{ product.price }} ₽
                </p>
              </div>
            </td>
            <td class="d-table__col">
              <div class="flex-center flex-center--vertical">
                <p
                  class="promotions__card-text promotions__card-text--bold product-table-card__discount product-table-card__value"
                >
                  {{ product.save_data.sale }} %
                </p>
                <button
                  class="d-button d-button-tertiary d-button-tertiary-small product-table-card__discount-button"
                  @click.prevent="settings(product, 'items')"
                >
                  <i class="d-icon-mixer product-table-card__discount-button-icon"></i>
                  Настроить
                </button>
              </div>
            </td>
            <td class="d-table__col">
              <div class="flex-center flex-center--vertical">
                <p class="promotions__card-text promotions__card-text--bold">Скидка</p>
                <p
                  class="product-table-card__text"
                  v-if="
                    product.save_data?.properties?.type_price?.guid == '0' &&
                    product.save_data?.properties?.type_pricing?.key == '0' &&
                    product.save_data?.properties?.type_formula?.key == '0'
                  "
                >
                  не задана
                </p>
                <p class="product-table-card__text" v-else>
                  {{
                    product.save_data?.properties?.type_formula?.key == '0' &&
                    product.save_data?.properties?.type_pricing?.key == '0' &&
                    product.save_data?.properties?.type_price?.guid?.length > 1
                      ? 'по типу цены'
                      : 'задана вручную'
                  }}
                </p>
              </div>
            </td>
            <td class="d-table__col">
              <div class="flex-center">
                <p
                  class="promotions__card-text promotions__card-text--bold product-table-card__value"
                >
                  {{ product.save_data.new_price }} ₽
                </p>
              </div>
            </td>
            <td class="d-table__col">
              <div class="flex-center">
                <Counter
                  @ElemCount="ElemCount"
                  :item="product"
                  :id="Number(product.id)"
                  field="min_count"
                  :min="1"
                  :value="Number(product.save_data.min_count)"
                  :key="new Date().getMilliseconds() + product.id"
                />
              </div>
            </td>
            <td class="d-table__col">
              <div class="flex-center">
                <Counter
                  @ElemCount="ElemCount"
                  :item="product"
                  :id="Number(product.id)"
                  field="multiplicity"
                  :min="1"
                  :value="Number(product.save_data.multiplicity)"
                  :key="new Date().getMilliseconds() + product.id"
                />
              </div>
            </td>
            <td class="d-table__col">
              <div class="flex-center">
                <button
                  class="d-icon-wrapper d-icon-wrapper--big"
                  @click="deleteSelect(product.id)"
                >
                  <i class="d-icon-trash d-table__icon"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- <div class="d-accordion visible-1200">
        <div class="d-accordion__header">
          <div class="d-product-list__header">
            <div class="d-radio__wrapper d-product-list__all">
              <label for="checkAll" class="d-radio__label">Выбрать все </label>
              <label class="d-radio d-radio--white">
                <input type="checkbox" name="checkAll" id="checkAll" class="d-radio__input" />
              </label>
            </div>
            <div
              class="d-divider d-divider--vertical d-divider--light d-product-list__header-divider"
            ></div>

            <button
              class="d-icon-wrapper d-icon-wrapper d-icon-wrapper--no-hover d-icon-wrapper--white d-product-list__header-button"
            >
              <i class="d-icon-angle-rounded-bottom"></i>
            </button>
          </div>
        </div>
        <div class="d-accordion__content">
          <div class="d-product-list__content">
            <div class="d-accordion d-product d-product--active">
              <div class="d-accordion__header">
                <div class="d-product__header">
                  <div class="d-product__header-content">
                    <img
                      src="/images/product2.svg"
                      alt=""
                      class="d-product__img"
                      width="50"
                      height="52"
                    />
                    <div class="d-product__header-info-container">
                      <div class="d-product__header-info">
                        <div class="d-product__top">
                          <div class="d-product__price">
                            <p class="d-product__price-value">1 750.00 ₽</p>
                            <div class="d-product__price-discount">30% ₽</div>
                          </div>
                          <div class="d-product__options">
                            <div class="d-radio__wrapper d-product-list__all">
                              <label class="d-radio d-radio--gray">
                                <input
                                  type="checkbox"
                                  name="check1"
                                  id="check1"
                                  class="d-radio__input"
                                />
                              </label>
                            </div>
                            <div
                              class="d-divider d-divider--vertical d-divider--black d-product-list__header-divider"
                            ></div>
                            <button
                              class="d-icon-wrapper d-icon-wrapper d-icon-wrapper--no-hover d-icon-wrapper--gray d-product-list__header-button"
                            >
                              <i class="d-icon-angle-rounded-bottom"></i>
                            </button>
                          </div>
                        </div>
                        <p class="d-product__title">
                          Аккумуляторная дрель-шуруповерт ИНТЕРСКОЛ ДА-10/14.4Л2
                        </p>
                        <p class="d-product__article">Арт: 844337</p>
                      </div>
                      <div class="d-product__multiple">
                        <p class="d-product__multiple-label">Кратность</p>
                        <div class="d-counter" data-counter="">
                          <button class="d-counter__button" data-counter-button="decrement">
                            <i class="d-icon-minus d-counter__button-icon"></i>
                          </button>
                          <input
                            class="d-counter__input"
                            type="text"
                            name="test-counter"
                            id="test-counter"
                            value="1"
                            data-counter-input=""
                          />
                          <button class="d-counter__button" data-counter-button="increment">
                            <i class="d-icon-plus d-counter__button-icon"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="d-accordion__content">
                <div class="d-product__content">
                  <div class="d-product__parameter">
                    <p class="d-product__parameter-title">РРЦ</p>
                    <div class="d-product__parameter-value">
                      <p class="d-product__price-text">1 750.00 ₽</p>
                    </div>
                  </div>
                  <div class="d-product__parameter">
                    <p class="d-product__parameter-title">Скидка</p>
                    <div class="d-product__parameter-value">
                      <div class="d-product__parameter-value-inner">
                        <p class="d-product__price-text">30% ₽</p>
                        <div class="d-divider d-divider--vertical d-divider--black"></div>
                        <div class="d-icon-wrapper d-icon-wrapper--no-hover d-icon-wrapper--black">
                          <i class="d-icon-mixer"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-product__parameter">
                    <p class="d-product__parameter-title">Тип ценообразования</p>
                    <div class="d-product__parameter-value">
                      <p class="d-product__parameter-text">
                        <span class="d-product__parameter-strong">Скидка</span
                        ><br class="visible-320" />
                        по формуле
                      </p>
                    </div>
                  </div>
                  <div class="d-product__parameter">
                    <p class="d-product__parameter-title">Цена с скидкой за шт.</p>
                    <div class="d-product__parameter-value">
                      <p class="d-product__price-text d-product__price-text--big">1 750.00 ₽</p>
                    </div>
                  </div>
                  <div class="d-product__parameter">
                    <p class="d-product__parameter-title">Минимальное количество</p>
                    <div class="d-product__parameter-value">
                      <div class="d-counter" data-counter="">
                        <button class="d-counter__button" data-counter-button="decrement">
                          <i class="d-icon-minus d-counter__button-icon"></i>
                        </button>
                        <input
                          class="d-counter__input"
                          type="text"
                          name="test-counter"
                          id="test-counter"
                          value="1"
                          data-counter-input=""
                        />
                        <button class="d-counter__button" data-counter-button="increment">
                          <i class="d-icon-plus d-counter__button-icon"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="d-product__parameter">
                    <p class="d-product__parameter-title">Максимальное количество</p>
                    <div class="d-product__parameter-value">
                      <div class="d-counter" data-counter="">
                        <button class="d-counter__button" data-counter-button="decrement">
                          <i class="d-icon-minus d-counter__button-icon"></i>
                        </button>
                        <input
                          class="d-counter__input"
                          type="text"
                          name="test-counter"
                          id="test-counter"
                          value="1"
                          data-counter-input=""
                        />
                        <button class="d-counter__button" data-counter-button="increment">
                          <i class="d-icon-plus d-counter__button-icon"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="d-product__parameter">
                    <p class="d-product__parameter-title">Кратность</p>
                    <div class="d-product__parameter-value">
                      <div class="d-counter" data-counter="">
                        <button class="d-counter__button" data-counter-button="decrement">
                          <i class="d-icon-minus d-counter__button-icon"></i>
                        </button>
                        <input
                          class="d-counter__input"
                          type="text"
                          name="test-counter"
                          id="test-counter"
                          value="1"
                          data-counter-input=""
                        />
                        <button class="d-counter__button" data-counter-button="increment">
                          <i class="d-icon-plus d-counter__button-icon"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="d-accordion d-product">
              <div class="d-accordion__header">
                <div class="d-product__header">
                  <div class="d-product__header-content">
                    <img
                      src="/images/product2.svg"
                      alt=""
                      class="d-product__img"
                      width="50"
                      height="52"
                    />
                    <div class="d-product__header-info-container">
                      <div class="d-product__header-info">
                        <div class="d-product__top">
                          <div class="d-product__price">
                            <p class="d-product__price-value">1 750.00 ₽</p>
                            <div class="d-product__price-discount">30% ₽</div>
                          </div>
                          <div class="d-product__options">
                            <div class="d-radio__wrapper d-product-list__all">
                              <label class="d-radio d-radio--gray">
                                <input
                                  type="checkbox"
                                  name="check1"
                                  id="check1"
                                  class="d-radio__input"
                                />
                              </label>
                            </div>
                            <div
                              class="d-divider d-divider--vertical d-divider--black d-product-list__header-divider"
                            ></div>
                            <button
                              class="d-icon-wrapper d-icon-wrapper d-icon-wrapper--no-hover d-icon-wrapper--gray d-product-list__header-button"
                            >
                              <i class="d-icon-angle-rounded-bottom"></i>
                            </button>
                          </div>
                        </div>
                        <p class="d-product__title">
                          Аккумуляторная дрель-шуруповерт ИНТЕРСКОЛ ДА-10/14.4Л2
                        </p>
                        <p class="d-product__article">Арт: 844337</p>
                      </div>
                      <div class="d-product__multiple">
                        <p class="d-product__multiple-label">Кратность</p>
                        <div class="d-counter" data-counter="">
                          <button class="d-counter__button" data-counter-button="decrement">
                            <i class="d-icon-minus d-counter__button-icon"></i>
                          </button>
                          <input
                            class="d-counter__input"
                            type="text"
                            name="test-counter"
                            id="test-counter"
                            value="1"
                            data-counter-input=""
                          />
                          <button class="d-counter__button" data-counter-button="increment">
                            <i class="d-icon-plus d-counter__button-icon"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>

                  <button class="d-product__delete">
                    <i class="d-icon-trash d-product__delete-icon"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="d-accordion d-product">
              <div class="d-product__header">
                <div class="d-product__header-content">
                  <img
                    src="/images/product2.svg"
                    alt=""
                    class="d-product__img"
                    width="50"
                    height="52"
                  />
                  <div class="d-product__header-info-container">
                    <div class="d-product__header-info">
                      <div class="d-product__top">
                        <div class="d-product__price">
                          <p class="d-product__price-value">1 750.00 ₽</p>
                          <div class="d-product__price-discount">30% ₽</div>
                        </div>
                        <div class="d-product__options">
                          <div class="d-radio__wrapper d-product-list__all">
                            <label class="d-radio d-radio--gray">
                              <input
                                type="checkbox"
                                name="check1"
                                id="check1"
                                class="d-radio__input"
                              />
                            </label>
                          </div>
                          <div
                            class="d-divider d-divider--vertical d-divider--black d-product-list__header-divider"
                          ></div>
                          <button
                            class="d-icon-wrapper d-icon-wrapper d-icon-wrapper--no-hover d-icon-wrapper--gray d-product-list__header-button"
                          >
                            <i class="d-icon-angle-rounded-bottom"></i>
                          </button>
                        </div>
                      </div>
                      <p class="d-product__title">
                        Аккумуляторная дрель-шуруповерт ИНТЕРСКОЛ ДА-10/14.4Л2
                      </p>
                      <p class="d-product__article">Арт: 844337</p>
                    </div>
                    <div class="d-product__multiple">
                      <p class="d-product__multiple-label">Кратность</p>
                      <div class="d-counter" data-counter="">
                        <button class="d-counter__button" data-counter-button="decrement">
                          <i class="d-icon-minus d-counter__button-icon"></i>
                        </button>
                        <input
                          class="d-counter__input"
                          type="text"
                          name="test-counter"
                          id="test-counter"
                          value="1"
                          data-counter-input=""
                        />
                        <button class="d-counter__button" data-counter-button="increment">
                          <i class="d-icon-plus d-counter__button-icon"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <button class="d-product__delete">
                  <i class="d-icon-trash d-product__delete-icon"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div> -->

      <div class="d-table__footer dart-mt-1">
        <div class="d-table__footer-content">
          <div class="d-table__footer-content-inner">
            <div class="d-table__footer-left">
              <div class="d-table__mark">
                Отмечено
                {{
                  this.filter_table_global
                    ? this.productsSelected.total
                    : Object.keys(this.table).length
                }}
                из
                {{ this.productsSelected.total }}
              </div>
              <div
                class="d-divider d-divider--vertical d-divider--big d-divider--black hidden-800"
              ></div>
              <div class="d-field-wrapper d-table__footer-all">
                <label class="d-switch" for="productsAll">
                  <input
                    type="checkbox"
                    name="productsAll"
                    id="productsAll"
                    class="d-switch__input"
                    :value="true"
                    v-model="this.filter_table_global"
                  />
                  <div class="d-switch__circle"></div>
                </label>
                <label for="productsAll" class="d-switch__label d-table__footer-all-label"
                  >Выбрать все элементы на всех страницах
                </label>
              </div>
            </div>
            <div class="d-table__footer-right">
              <button class="d-select hidden-1200" @click.prevent="massActions">
                <span class="d-select__title">Массовые действия</span>
                <!-- <i class="d-icon-angle-rounded-bottom d-select__arrow"></i> -->
              </button>
              <button class="d-select d-select--squared visible-1200" @click.prevent="massActions">
                <span class="d-select__title">Массовые действия</span>
                <!-- <i class="d-icon-angle-rounded-bottom d-select__arrow"></i> -->
              </button>
            </div>
          </div>
          <div class="d-pagination-wrap" v-if="pagesCount > 1">
            <paginate
              :page-count="pagesCount"
              :click-handler="pageClick"
              :prev-text="'Пред'"
              :next-text="'След'"
              :container-class="'d-pagination d-table__footer-right-pagination'"
              :page-class="'d-pagination__item'"
              :active-class="'d-pagination__item--active'"
              :initialPage="this.productsSelectedPage"
              :forcePage="this.productsSelectedPage"
            >
            </paginate>
          </div>
        </div>
      </div>
    </div>
    <div v-else>
      <div class="dart-alert dart-alert-info">
        Таблица с товарами появится тогда, когда вы выберите хоть один товар или загрузите
        номенклатуру файлом.
      </div>
    </div>
  </div>
</template>
<script>
import Checkbox from 'primevue/checkbox'
import Counter from '@/shared/ui/Counter.vue'
import Paginate from 'vuejs-paginate-next'

export default {
  name: 'actionProducts',
  components: { Checkbox, Counter, Paginate },
  emits: [
    'paginateProductsSelected',
    'paginateProductsAvailable',
    'filterProductsSelected',
    'filterProductsAvailable',
    'selectProduct',
    'deSelectProduct',
    'settingsProduct',
    'changeMultiplicity',
    'changeMinCount',
    'openFileDialog',
    'settings',
  ],
  props: {
    productsSelected: {
      type: Object,
      default() {
        return {}
      },
    },
    productsAvailable: {
      type: Object,
      default() {
        return {}
      },
    },
    productsAvailablePage: {
      type: Number,
      default: 1,
    },
    productsSelectedPage: {
      type: Number,
      default: 1,
    },
    perPage: {
      type: Number,
      default: 25,
    },
  },
  data() {
    return {
      suggestionsShow: false,
      search: '',
      searchPTimer: null,
      selected: [],
      table: [],
      checked_all: false,
      filter_table_global: false,
      filter_table: false,
    }
  },
  methods: {
    pageClick(pageNum) {
      this.$emit('paginateProductsSelected', {
        page: pageNum,
      })
    },
    selectProduct(item) {
      this.search = ''
      console.log(item)
      this.$emit('selectProduct', item)
    },
    unActivate() {
      setTimeout(() => (this.suggestionsShow = false), 250)
    },
    debounce(func, delay) {
      clearTimeout(this.searchPTimer)
      this.searchPTimer = setTimeout(func, delay)
    },
    ElemCount(data) {
      if (data.field == 'min_count') {
        this.$emit('changeMinCount', data)
      }
      if (data.field == 'multiplicity') {
        this.$emit('changeMultiplicity', data)
      }
    },
    deleteSelect(data) {
      this.$emit('deSelectProduct', data)
    },
    openFileDialog() {
      this.$emit('openFileDialog')
    },
    globalTable() {
      this.selected_all = this.total
    },
    checkAll() {
      if (!this.checked_all) {
        const tmp = []
        for (let i = 0; i < this.productsSelected.products.length; i++) {
          tmp.push(Number(this.productsSelected.products[i].id))
        }
        this.table = tmp
      } else {
        this.table = []
      }
    },
    settings(item, type) {
      this.selected = []
      this.selected.push(item)
      this.$emit('settings', this.selected, type)
    },
    massActions() {
      this.selected = []
      var type = 'items'
      if (this.filter_table_global) {
        type = 'all'
        this.selected.push(1)
        this.selected.push(2)
      } else {
        console.log(this.table)
        Object.entries(this.table).forEach((val) => {
          const [key, value] = val
          Object.entries(this.productsSelected.products).forEach((ival) => {
            const [ikey, ivalue] = ival
            if (value == ivalue.id) {
              this.selected.push(ivalue)
            }
          })
        })
      }
      console.log(this.selected)
      this.$emit('settings', this.selected, type)
    },
  },
  computed: {
    pagesCount() {
      let pages = Math.ceil(this.productsSelected.total / this.perPage)
      if (pages === 0) {
        pages = 1
      }
      return pages
    },
  },
  watch: {
    productsAvailable: function () {
      this.filter_table_global = false
    },
    table: function (newVal) {
      if (this.productsSelected.products.length != newVal.length) {
        this.checked_all = false
      } else {
        this.checked_all = true
      }
    },
    filter_table_global: function (newVal) {
      if (newVal) {
        this.table = []
      }
    },
    search(newVal) {
      if (newVal.length < 3) {
        return
      }
      this.debounce(() => {
        this.$emit('filterProductsAvailable', this.search)
      }, 300)
    },
  },
}
</script>
<style lang="scss"></style>
