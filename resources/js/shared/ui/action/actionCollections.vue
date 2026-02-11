<template>
  <div>
    <div class="promotions__card-warehouse">
      <div class="promotions__card-value-container promotions__card-warehouse-header">
        <p class="promotions__card-value promotions__card-value--bold promotions__card-block-title">
          Коллекции
        </p>
        <span class="promotions__card-label"
          >Загрузите список товаров и установите скидки, которые получит клиент при выполнении
          условий акции</span
        >
      </div>
      <form class="d-search d-search--alt promotions__card-warehouse-search hidden-600">
        <i class="d-icon-search-big d-search__icon promotions__card-warehouse-search-icon"></i>
        <input
          type="text"
          placeholder="Найти коллекцию по наименованию"
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
          <div v-for="suggestion in collectionsAvailable.items" :key="suggestion.id">
            <li class="d-search__suggestion" v-if="!collections.hasOwnProperty(suggestion.id)">
              <div class="d-search__suggestion-card" @click="selectCollection(suggestion)">
                <div class="d-search__suggestion-card__content">
                  <span class="d-search__suggestion-card__title">{{ suggestion.name }}</span>
                </div>
              </div>
            </li>
          </div>
        </ul>
      </form>
    </div>
    {{ collections.length }}
    <div class="tab-container" v-if="Object.keys(this.collections).length">
      <div class="tab-button-container">
        <template v-for="el in this.collections" :key="el.group.id">
          <button
            @click.prevent="value = el.group.id"
            class="tab-button"
            :class="{
              active: this.value == el.group.id,
            }"
          >
            {{ el.group.name + ' (' + el?.products?.total + ')' }}
          </button>
        </template>
      </div>
      <Tabs class="tab-custom dart-mt-1" :scrollable="true" v-model:value="value" v-if="value">
        <TabPanels>
          <TabPanel
            v-for="el in this.collections"
            :value="el.group.id"
            :header="el.group.name + ' (' + el?.products?.total + ')'"
            :key="el.id"
          >
            <div class="promotions__card-collection-header hidden-1200">
              <h2 class="promotions__card-title">Коллекция "{{ el.group.name }}"</h2>
              <div
                class="d-divider d-divider--vertical promotions__card-collection-header-divider"
              ></div>
              <button
                class="d-icon-wrapper d-icon-wrapper--big"
                @click="deleteCollection(el.group.id)"
              >
                <i class="d-icon-trash"></i>
              </button>
            </div>
            <div
              class="d-field-container d-field-container--vertical d-field-container--long promotions__card-collection-search"
            >
              <p class="promotions__card-text">Поиск товаров по коллекции</p>
              <form class="d-search">
                <input
                  type="text"
                  placeholder="Наименование или артикул"
                  class="d-search__field"
                  v-model="searchProducts"
                />
              </form>
            </div>

            <div class="d-table__container promotions__card-products">
              <div class="d-table__wrapper hidden-1200">
                <div class="d-table__decoration-wrapper">
                  <div class="d-table__decoration"></div>
                </div>

                <table class="d-table d-table--decoration" v-if="el.products">
                  <thead class="d-table__head">
                    <tr class="d-table__row">
                      <th class="d-table__head-col d-table__head-col--big" style="width: 20%">
                        Товар
                      </th>
                      <th class="d-table__head-col d-table__head-col--big">РРЦ</th>
                      <th class="d-table__head-col d-table__head-col--big">
                        Скидка
                        <button
                          @click="settings(el.group.id, 'group')"
                          class="d-button d-button-tertiary d-button-tertiary-small product-table-card__discount-button product-table-card__discount-button--table mt-4"
                        >
                          <i class="d-icon-mixer product-table-card__discount-button-icon"></i>
                          Настроить
                        </button>
                      </th>
                      <th class="d-table__head-col d-table__head-col--big">Тип ценообразования</th>
                      <th class="d-table__head-col d-table__head-col--big">
                        Цена со скидкой за шт.
                      </th>
                    </tr>
                  </thead>
                  <tbody class="d-table__body promotions__product-card">
                    <tr
                      class="d-table__row"
                      v-for="product in el.products?.items"
                      :key="product.id"
                    >
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
                            {{ product.store_name }}
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
                        </div>
                      </td>
                      <td class="d-table__col">
                        <div class="flex-center flex-center--vertical">
                          <p class="promotions__card-text promotions__card-text--bold">Скидка</p>
                          <p
                            class="product-table-card__text"
                            v-if="
                              (el.type_price == '0' &&
                                el.type_formula == '0' &&
                                el.type_pricing == '0') ||
                              (el.properties?.type_price == '0' &&
                                el.properties?.type_formula == '0' &&
                                el.properties?.type_pricing == '0')
                            "
                          >
                            не задана
                          </p>
                          <p class="product-table-card__text" v-else>
                            {{
                              el.properties?.type_price?.guid?.length &&
                              el.properties.type_formula == '0' &&
                              el.properties.type_pricing == '0'
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
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="d-accordion visible-1200">
                <div class="d-accordion__header">
                  <div class="d-product-list__header">
                    <div class="d-radio__wrapper d-product-list__all">
                      <label for="checkAll" class="d-radio__label">Выбрать все </label>
                      <label class="d-radio d-radio--white">
                        <input
                          type="checkbox"
                          name="checkAll"
                          id="checkAll"
                          class="d-radio__input"
                        />
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
                                <div
                                  class="d-icon-wrapper d-icon-wrapper--no-hover d-icon-wrapper--black"
                                >
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
                              <p class="d-product__price-text d-product__price-text--big">
                                1 750.00 ₽
                              </p>
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
                  </div>
                </div>
              </div>

              <div class="d-table__footer">
                <div class="d-pagination-wrap" v-if="pagesCount(el) > 1">
                  <paginate
                    :page-count="pagesCount(el)"
                    :click-handler="pageClick"
                    :prev-text="'Пред'"
                    :next-text="'След'"
                    :container-class="'d-pagination d-table__footer-right-pagination'"
                    :page-class="'d-pagination__item'"
                    :active-class="'d-pagination__item--active'"
                    :initialPage="el.group.page"
                    :forcePage="el.group.page"
                  >
                  </paginate>
                </div>
              </div>
            </div>
          </TabPanel>
        </TabPanels>
      </Tabs>
    </div>
    <div v-else>
      <div class="dart-alert dart-alert-info dart-mt-1">
        Список товаров появится после добавления хотя бы одной коллекции. Воспользуйтесь поиском.
      </div>
    </div>
  </div>
</template>
<script>
import Tabs from 'primevue/tabs'
import TabPanels from 'primevue/tabpanels'
import TabPanel from 'primevue/tabpanel'
import Paginate from 'vuejs-paginate-next'

export default {
  name: 'actionCollections',
  emits: [
    'filterCollections',
    'paginateGroup',
    'filterGroup',
    'filterGroupProduct',
    'selectCollection',
    'deleteCollection',
    'settings',
  ],
  components: { Paginate, Tabs, TabPanels, TabPanel },
  props: {
    collectionsAvailable: {
      type: Object,
      default() {
        return {}
      },
    },
    collections: {
      type: Object,
      default() {
        return {}
      },
    },
    groupPage: {
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
      searchProducts: '',
      searchPTimer: null,
      selected: [],
      table: [],
      value: '',
    }
  },
  methods: {
    unActivate() {
      setTimeout(() => (this.suggestionsShow = false), 250)
    },
    pageClick(pageNum) {
      this.$emit('paginateGroup', {
        page: pageNum,
        group_id: this.value,
      })
    },
    settings(item, type) {
      this.selected = []
      this.selected.push(item)
      this.$emit('settings', this.selected, type)
    },
    debounce(func, delay) {
      clearTimeout(this.searchPTimer)
      this.searchPTimer = setTimeout(func, delay)
    },
    selectCollection(item) {
      this.search = ''
      this.$emit('selectCollection', item)
    },
    deleteCollection(id) {
      this.$emit('deleteCollection', id)
    },
    pagesCount(el) {
      if (el.products) {
        let pages = Math.ceil(el.products.total / this.perPage)
        if (pages === 0) {
          pages = 1
        }
        return pages
      }
      return 0
    },
  },
  computed: {},
  watch: {
    search(newVal) {
      if (newVal.length < 3) {
        if (newVal == '') {
          this.debounce(() => {
            this.$emit('filterGroup', { filter: '' })
          }, 300)
        }
        return
      }
      this.debounce(() => {
        this.$emit('filterGroup', { filter: this.search })
      }, 300)
    },
    searchProducts(newVal) {
      if (newVal.length < 3) {
        if (newVal == '') {
          this.debounce(() => {
            this.$emit('filterGroupProduct', { filter: '', group_id: this.value, page: 1 })
          }, 300)
        }
        return
      }
      this.debounce(() => {
        this.$emit('filterGroupProduct', {
          filter: this.searchProducts,
          group_id: this.value,
          page: 1,
        })
      }, 300)
    },
  },
}
</script>
<style lang="scss">
body {
  .p-tabpanels {
    background: transparent;
  }
}
.tab-button-container {
  width: 100%;
  display: flex;
  gap: 16px;
  margin-top: 24px;
  .tab-button {
    display: inline-block;
    font-weight: 600;
    font-size: 16px;
    background: #ededed;
    color: #757575;
    border-radius: 35px;
    padding: 10px 15px;
    transition: all 0.2s ease;
    &.active,
    &:hover {
      background: #282828;
      color: #fff;
      transition: all 0.2s ease;
    }
  }
}
</style>
