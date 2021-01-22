<template>
  <v-layout>
    <v-flex xs12 md12>
      <v-container grid-list-md>
        <v-layout row wrap>
          <v-flex xs12 md3>
            <v-list subheader>
              <v-subheader>Quick Links</v-subheader>
              <v-list-tile v-if="checkRoleImport('ppjk')" @click="$router.push({ name: 'monitorDoc' })">
                <v-list-tile-action>
                  <v-icon color="blue">book</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Transaksi PPJK</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-list-tile v-if="checkRoleImport('import')" @click="$router.push({ name: 'transactImportIndex' })">
                <v-list-tile-action>
                  <v-icon color="blue">bookmarks</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Transaksi Import</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-list-tile v-if="checkRoleImport('trading')" @click="$router.push({ name: 'transactTradingIndex' })">
                <v-list-tile-action>
                  <v-icon color="blue">bookmarks</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Transaksi Trading</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>

              <v-list-tile v-if="checkRoleImport('export')" @click="$router.push({ name: 'transactExportIndex' })">
                <v-list-tile-action>
                  <v-icon color="blue">bookmarks</v-icon>
                </v-list-tile-action>

                <v-list-tile-content>
                  <v-list-tile-title>Transaksi Export</v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
          </v-flex>

          <v-flex xs12 md9>
            <v-toolbar dense flat color="white" class="mb-5px">
              <v-subheader>Notification</v-subheader>
              <!--              <v-toolbar-title class="hidden-xs-only">Notification</v-toolbar-title>-->
              <v-spacer></v-spacer>

              <v-btn icon @click="getData('Document')">
                <v-icon>refresh</v-icon>
              </v-btn>
            </v-toolbar>
            <!--data table-->
            <v-data-table
              :headers="header"
              :items="dataResult"
              :pagination.sync="pagination"
              :total-items="total"
              :rows-per-page-items="rowsPerPageItems"
              :loading="loading"
              class="elevation-1"
            >
              <template slot="items" slot-scope="props">
                <td
                  @click="counter += 1, redirect(props.item)"
                  class="text-xs-left"
                >{{ formatDate(props.item) }}
                </td>
                <td @click="counter += 1, redirect(props.item)" class="text-xs-left">
                  <v-icon v-if="props.item.Read == '0'" color="blue">mail</v-icon>
                  <v-icon v-else color="green">drafts</v-icon>
                </td>
                <td
                  @click="counter += 1, redirect(props.item)"
                  class="text-xs-left"
                >{{ props.item.Messages }}
                </td>
                <td class="text-xs-left">
                  <v-icon small class="mr-2" @click="redirect(props.item)">edit</v-icon>
                </td>
              </template>
              <template slot="no-data">
                <p>Notification's empty.</p>
              </template>
            </v-data-table>
          </v-flex>

          <v-flex xs12 md12 v-if="checkRoleImport('import')">
            <v-subheader>Status Import</v-subheader>
            <v-layout wrap>
              <v-flex md12>
                <v-tabs centered color="white" show-arrows>
                  <v-tabs-slider color="green"></v-tabs-slider>

                  <v-tab href="#tab-1">
                    Process To Tenant
                    <v-icon>mdi-account</v-icon>
                  </v-tab>

                  <v-tab href="#tab-2">
                    Process To Jakarta
                    <v-icon>mdi-account</v-icon>
                  </v-tab>

                  <v-tab href="#tab-3">
                    Process To PPJK
                    <v-icon>mdi-account</v-icon>
                  </v-tab>

                  <v-tab href="#tab-4">
                    BC 2.0
                    <v-icon>mdi-account</v-icon>
                  </v-tab>

                  <v-tab href="#tab-5">
                    Closed
                    <v-icon>mdi-account</v-icon>
                  </v-tab>

                  <v-tab-item :value="'tab-' + 1">
                    <v-card flat>
                      <v-card-text>
                        <v-flex md12>
                          <v-toolbar dense flat color="blue" class="mb-5px">
                            <v-subheader>Process To Tenant</v-subheader>
                            <!--              <v-toolbar-title class="hidden-xs-only">Process Tenant</v-toolbar-title>-->
                            <v-spacer></v-spacer>

                            <v-btn icon @click="getDataTenant">
                              <v-icon>refresh</v-icon>
                            </v-btn>
                          </v-toolbar>
                          <!--data table-->
                          <v-flex md12>
                            <v-data-table
                              :headers="headerStatus"
                              :items="dataResultNotifTenant"
                              :pagination.sync="paginationNotifTenant"
                              :total-items="totalNotifTenant"
                              :rows-per-page-items="rowsPerPageItems"
                              :loading="loading"
                              class="elevation-1"
                            >
                              <template slot="items" slot-scope="props">
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.DocNum }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.Tenant }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.No_bl }}
                                </td>
                                <td class="text-xs-left">
                                  <v-icon
                                    small
                                    class="mr-2"
                                    @click="redirectToDocument(props.item)"
                                  >edit
                                  </v-icon>
                                </td>
                              </template>
                              <template slot="no-data">
                                <p>Notification's empty.</p>
                              </template>
                            </v-data-table>
                          </v-flex>
                        </v-flex>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>

                  <v-tab-item :value="'tab-' + 2">
                    <v-card flat>
                      <v-card-text>
                        <v-flex md12>
                          <v-toolbar dense flat color="orange" class="mb-5px">
                            <v-subheader>Process To Jakarta</v-subheader>
                            <!--              <v-toolbar-title class="hidden-xs-only">Process to Jakarta</v-toolbar-title>-->
                            <v-spacer></v-spacer>

                            <v-btn icon @click="getDataJkt">
                              <v-icon>refresh</v-icon>
                            </v-btn>
                          </v-toolbar>
                          <!--data table-->
                          <v-flex md12>
                            <v-data-table
                              :headers="headerStatus"
                              :items="dataResultNotifJkt"
                              :pagination.sync="paginationNotifJkt"
                              :total-items="totalNotifJkt"
                              :rows-per-page-items="rowsPerPageItems"
                              :loading="loading"
                              class="elevation-1"
                            >
                              <template slot="items" slot-scope="props">
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.DocNum }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.Tenant }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.No_bl }}
                                </td>
                                <td class="text-xs-left">
                                  <v-icon
                                    small
                                    class="mr-2"
                                    @click="redirectToDocument(props.item)"
                                  >edit
                                  </v-icon>
                                </td>
                              </template>
                              <template slot="no-data">
                                <p>Notification's empty.</p>
                              </template>
                            </v-data-table>
                          </v-flex>
                        </v-flex>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>

                  <v-tab-item :value="'tab-' + 3">
                    <v-card flat>
                      <v-card-text>
                        <v-flex md12>
                          <v-toolbar dense flat color="green" class="mb-5px">
                            <v-subheader>Process To PPJK</v-subheader>
                            <!--              <v-toolbar-title class="hidden-xs-only">Process to PPJK</v-toolbar-title>-->
                            <v-spacer></v-spacer>

                            <v-btn icon @click="getDataPPJK">
                              <v-icon>refresh</v-icon>
                            </v-btn>
                          </v-toolbar>
                          <!--data table-->
                          <v-flex md12>
                            <v-data-table
                              :headers="headerStatus"
                              :items="dataResultNotifPPJK"
                              :pagination.sync="paginationNotifPPJK"
                              :total-items="totalNotifPPJK"
                              :rows-per-page-items="rowsPerPageItems"
                              :loading="loading"
                              class="elevation-1"
                            >
                              <template slot="items" slot-scope="props">
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.DocNum }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.Tenant }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.No_bl }}
                                </td>
                                <td class="text-xs-left">
                                  <v-icon
                                    small
                                    class="mr-2"
                                    @click="redirectToDocument(props.item)"
                                  >edit
                                  </v-icon>
                                </td>
                              </template>
                              <template slot="no-data">
                                <p>Notification's empty.</p>
                              </template>
                            </v-data-table>
                          </v-flex>
                        </v-flex>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>

                  <v-tab-item :value="'tab-' + 4">
                    <v-card flat>
                      <v-card-text>
                        <v-flex md12>
                          <v-toolbar dense flat color="orange" class="mb-5px">
                            <v-subheader>BC 2.0</v-subheader>
                            <!--              <v-toolbar-title class="hidden-xs-only">BC 2.0</v-toolbar-title>-->
                            <v-spacer></v-spacer>

                            <v-btn icon @click="getDataBC20">
                              <v-icon>refresh</v-icon>
                            </v-btn>
                          </v-toolbar>
                          <!--data table-->
                          <v-flex md12>
                            <v-data-table
                              :headers="headerStatus"
                              :items="dataResultNotifTenantBC20"
                              :pagination.sync="paginationNotifTenantBC20"
                              :total-items="totalNotifTenantBC20"
                              :rows-per-page-items="rowsPerPageItems"
                              :loading="loading"
                              class="elevation-1"
                            >
                              <template slot="items" slot-scope="props">
                                <td
                                  @click="counter += 1, redirectToDocument20(props.item)"
                                  class="text-xs-left"
                                >
                                  {{ props.item.DocNum
                                  }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument20(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.Tenant }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument20(props.item)"
                                  class="text-xs-left"
                                >
                                  {{ props.item.No_bl
                                  }}
                                </td>
                                <td class="text-xs-left">
                                  <v-icon
                                    small
                                    class="mr-2"
                                    @click="redirectToDocument20(props.item)"
                                  >edit
                                  </v-icon>
                                </td>
                              </template>
                              <template slot="no-data">
                                <p>Notification's empty.</p>
                              </template>
                            </v-data-table>
                          </v-flex>
                        </v-flex>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>

                  <v-tab-item :value="'tab-' + 5">
                    <v-card flat>
                      <v-card-text>
                        <v-flex md12>
                          <v-toolbar dense flat color="orange" class="mb-5px">
                            <v-subheader>Closed</v-subheader>
                            <!--              <v-toolbar-title class="hidden-xs-only">BC 2.0</v-toolbar-title>-->
                            <v-spacer></v-spacer>

                            <v-btn icon @click="getDataClosed">
                              <v-icon>refresh</v-icon>
                            </v-btn>
                          </v-toolbar>
                          <!--data table-->
                          <v-flex md12>
                            <v-data-table
                              :headers="headerStatus"
                              :items="dataResultClosed"
                              :pagination.sync="paginationNotifClosed"
                              :total-items="totalNotifClosed"
                              :rows-per-page-items="rowsPerPageItems"
                              :loading="loading"
                              class="elevation-1"
                            >
                              <template slot="items" slot-scope="props">
                                <td
                                  @click="counter += 1, redirectToDocument20(props.item)"
                                  class="text-xs-left"
                                >
                                  {{ props.item.DocNum
                                  }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument20(props.item)"
                                  class="text-xs-left"
                                >{{ props.item.Tenant }}
                                </td>
                                <td
                                  @click="counter += 1, redirectToDocument20(props.item)"
                                  class="text-xs-left"
                                >
                                  {{ props.item.No_bl
                                  }}
                                </td>
                                <td class="text-xs-left">
                                  <v-icon
                                    small
                                    class="mr-2"
                                    @click="redirectToDocument20(props.item)"
                                  >edit
                                  </v-icon>
                                </td>
                              </template>
                              <template slot="no-data">
                                <p>Notification's empty.</p>
                              </template>
                            </v-data-table>
                          </v-flex>
                        </v-flex>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                </v-tabs>
              </v-flex>
            </v-layout>
          </v-flex>

          <v-flex xs12 md12>
            <v-toolbar dense flat color="white" class="mb-5px">
              <v-subheader>Notification Attachment</v-subheader>
              <!--              <v-toolbar-title class="hidden-xs-only">Notification</v-toolbar-title>-->
              <v-spacer></v-spacer>

              <v-btn icon @click="getDataAttach('Attachment')">
                <v-icon>refresh</v-icon>
              </v-btn>
            </v-toolbar>
            <!--data table-->
            <v-data-table
              :headers="header"
              :items="dataResultAttach"
              :pagination.sync="paginationAttach"
              :total-items="totalAttach"
              :rows-per-page-items="rowsPerPageItems"
              :loading="loading"
              class="elevation-1"
            >
              <template slot="items" slot-scope="props">
                <td
                  @click="counter += 1, redirectToDocument20(props.item, 'attach')"
                  class="text-xs-left"
                >{{ formatDate(props.item) }}
                </td>
                <td @click="counter += 1, redirectToDocument20(props.item, 'attach')" class="text-xs-left">
                  <v-icon v-if="props.item.Read == '0'" color="blue">mail</v-icon>
                  <v-icon v-else color="green">drafts</v-icon>
                </td>
                <td
                  @click="counter += 1, redirectToDocument20(props.item, 'attach')"
                  class="text-xs-left"
                >{{ props.item.Messages }}
                </td>
                <td class="text-xs-left">
                  <v-icon small class="mr-2" @click="redirectToDocument20(props.item, 'attach')">edit</v-icon>
                </td>
              </template>
              <template slot="no-data">
                <p>Notification's empty.</p>
              </template>
            </v-data-table>
          </v-flex>
        </v-layout>

        <v-snackbar v-model="snackbar" bottom right :timeout="timeout">
          {{ textSnackbar }}
          <v-btn color="red" flat @click="snackbar = false">Close</v-btn>
        </v-snackbar>
      </v-container>
    </v-flex>
  </v-layout>
</template>

<script>
import axios from 'axios'

export default {
  name: 'Welcome',
  props: ['user'],
  data: () => ({
    items: [],
    counter: 0,
    message: '',
    success: '',
    loading: false,
    search: '',
    row: [],
    insert: true,

    snackbar: false,
    timeout: 6000,
    textSnackbar: '',

    dataResult: [],
    dataResultAttach: [],
    dataResultNotifPPJK: [],
    dataResultNotifTenant: [],
    dataResultNotifJkt: [],
    dataResultNotifTenantBC20: [],
    dataResultClosed: [],
    total: 0,
    totalNotifJkt: 0,
    totalAttach: 0,
    totalNotifPPJK: 0,
    totalNotifTenant: 0,
    totalNotifTenantBC20: 0,
    totalNotifClosed: 0,
    rowsPerPageItems: [5, 10, 20, 50, 100],
    pagination: {},
    paginationNotifJkt: {},
    paginationAttach: {},
    paginationNotifTenant: {},
    paginationNotifTenantBC20: {},
    paginationNotifPPJK: {},
    paginationNotifClosed: {},

    header: [
      { text: 'Created', value: 'created_at' },
      { text: 'Status', value: 'Read' },
      { text: 'Messages', value: 'Messages' },
      { text: 'Action', value: 'action', sortable: false }
    ],

    headerStatus: [
      { text: 'DocNum', value: 'DocNum' },
      { text: 'Tenant', value: 'Tenant' },
      { text: 'B/L', value: 'No_bl' },
      { text: 'Action', value: 'action', sortable: false }
    ]
  }),

  created () {
    // this.getItems()
    this.checkLogin()
    this.getUserDisplay()
  },

  mounted () {
    // this.getTenant()
    // this.getCargo()
    this.getCurrency()
    this.getCategoryItem()
    this.getRemark()
    this.getPPJK()
    this.getTenantTable()
    this.getBPTable()
  },

  watch: {
    search () {
      this.getData()
    },

    pagination: {
      handler () {
        this.getData('Document')
      },
      deep: true
    },

    paginationAttach: {
      handler () {
        this.getDataAttach('Attachment')
      },
      deep: true
    },

    paginationNotifJkt: {
      handler () {
        this.getDataJkt()
      },
      deep: true
    },

    paginationNotifTenant: {
      handler () {
        this.getDataTenant()
      },
      deep: true
    },

    paginationNotifPPJK: {
      handler () {
        this.getDataPPJK()
      },
      deep: true
    },

    paginationNotifTenantBC20: {
      handler () {
        this.getDataBC20()
      },
      deep: true
    },

    paginationNotifClosed: {
      handler () {
        this.getDataClosed()
      },
      deep: true
    }
  },

  methods: {
    checkRoleImport (type) {
      let role = JSON.parse(localStorage.getItem('role'))
      if (type === 'import') {
        return role.includes('KB Import')
      } else if (type === 'trading') {
        return role.includes('KB Trading')
      } else if (type === 'ppjk') {
        return role.includes('Transaksi PPJK')
      } else if (type === 'export') {
        return role.includes('KB Export')
      }
    },

    getTenantTable () {
      if (localStorage.getItem('tenant') === null) {
        axios.get(`/api/master/tenant?pluck=1`).then(res => {
          localStorage.setItem('tenant', JSON.stringify(res.data.rows))
        })
      }
    },

    getBPTable () {
      if (localStorage.getItem('bp') === null) {
        axios.get(`/api/master/bp?pluck=1`).then(res => {
          localStorage.setItem('bp', JSON.stringify(res.data.rows))
        })
      }
    },

    getPPJK () {
      if (localStorage.getItem('ppjk') === null) {
        axios.get(`/api/master/ppjk?pluck=1`).then(res => {
          // console.log(res.data.rows)
          localStorage.setItem('ppjk', JSON.stringify(res.data.rows))
        })
      }
    },

    getRemark () {
      if (localStorage.getItem('remark') === null) {
        axios.get(`/api/master/remark?pluck=1`).then(res => {
          localStorage.setItem('remark', JSON.stringify(res.data.rows))
        })
      }
    },

    getCategoryItem () {
      if (localStorage.getItem('categoryItem') === null) {
        axios.get(`/api/master/category-item?pluck=1`).then(res => {
          localStorage.setItem('categoryItem', JSON.stringify(res.data.rows))
          // process(res.data.rows)
        })
      }
    },

    getCurrency () {
      if (localStorage.getItem('currency') === null) {
        axios.get(`/api/master/currency?pluck=1`).then(res => {
          localStorage.setItem('currency', JSON.stringify(res.data.rows))
        })
      }
    },

    getUserDisplay () {
      axios
        .get(`/api/master/display-form-user-show`, {
          params: {
            type: 'Import'
          }
        })
        .then(res => {
          localStorage.setItem('userForm', JSON.stringify(res.data.userDisplay))
          localStorage.setItem('tenantExternal', JSON.stringify(res.data.tenantExternal))
        })
    },

    checkLogin () {
      let check = this.$route.query.newLogin
      let vm = this
      if (check === 1) {
        setTimeout(function () {
          vm.snackbar = true
          vm.timeout = 6000
          vm.textSnackbar = 'Hi, ' + vm.user.name + ' Welcome back.'
        }, 500)
      }
    },

    getItems () {
      axios.get(`/api/dashboard/ppjk`).then(res => {
        this.items = res.data
      })
    },

    redirectToDocument20 (item, type) {
      if (type === 'attach') {
        axios.put(`/api/notification/${item.DocEntry}`).then(res => {
          this.$emit('updateNotification', res)
          this.$router.push({
            name: 'transactImportView',
            params: { id: item.DocNumHeader, status: 'update' },
            query: { entry: item.DocNo }
          })
        })
      } else {
        this.$router.push({
          name: 'transactImportView',
          params: { id: item.DocNumHeader, status: 'update' },
          query: { entry: item.DocNo }
        })
      }
    },

    redirectToDocument (item) {
      this.$router.push({
        name: 'transactImport',
        params: { id: item.DocNumHeader, status: 'update' },
        query: { entry: item.DocNo }
      })
    },

    redirect (item) {
      if (item.Type === 'IP') {
        axios.put(`/api/notification/${item.DocEntry}`).then(res => {
          this.$emit('updateNotification', res)
          this.$router.push({
            name: 'transactImport',
            params: { id: item.DocNum, status: 'update' }
          })
        })
      } else if (item.Type === 'TD') {
        axios.put(`/api/notification/${item.DocEntry}`).then(res => {
          this.$emit('updateNotification', res)
          this.$router.push({
            name: 'transactTrading',
            params: { id: item.DocNum, status: 'update' }
          })
        })
      }
    },

    formatDate (notif) {
      return window.moment(notif.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow()
    },

    getData (type) {
      this.loading = true
      // get by search keyword
      if (this.search) {
        axios
          .get(`/api/all-notification`, {
            params: {
              q: this.search,
              type: type,
              page: this.pagination.page,
              rows: this.pagination.rowsPerPage
            }
          })
          .then(res => {
            this.dataResult = res.data.rows
            this.total = res.data.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
      // get by sort option
      if (this.pagination.sortBy && !this.search) {
        const direction = this.pagination.descending ? 'desc' : 'asc'
        axios
          .get(`/api/all-notification`, {
            params: {
              order: direction,
              type: type,
              sort: this.pagination.sortBy,
              page: this.pagination.page,
              rows: this.pagination.rowsPerPage
            }
          })
          .then(res => {
            this.loading = false
            this.dataResult = res.data.rows
            this.total = res.data.total
          })
      }

      if (!this.search && !this.pagination.sortBy) {
        axios
          .get(`/api/all-notification`, {
            params: {
              page: this.pagination.page,
              type: type,
              rows: this.pagination.rowsPerPage
            }
          })
          .then(res => {
            this.dataResult = res.data.rows
            this.total = res.data.meta.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
    },

    getDataAttach (type) {
      this.loading = true
      // get by search keyword
      if (this.search) {
        axios
          .get(`/api/all-notification`, {
            params: {
              q: this.search,
              type: type,
              page: this.paginationAttach.page,
              rows: this.paginationAttach.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultAttach = res.data.rows
            this.totalAttach = res.data.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
      // get by sort option
      if (this.paginationAttach.sortBy && !this.search) {
        const direction = this.paginationAttach.descending ? 'desc' : 'asc'
        axios
          .get(`/api/all-notification`, {
            params: {
              order: direction,
              type: type,
              sort: this.paginationAttach.sortBy,
              page: this.paginationAttach.page,
              rows: this.paginationAttach.rowsPerPage
            }
          })
          .then(res => {
            this.loading = false
            this.dataResultAttach = res.data.rows
            this.totalAttach = res.data.total
          })
      }

      if (!this.search && !this.paginationAttach.sortBy) {
        axios
          .get(`/api/all-notification`, {
            params: {
              page: this.paginationAttach.page,
              type: type,
              rows: this.paginationAttach.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultAttach = res.data.rows
            this.totalAttach = res.data.meta.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
    },

    getDataPPJK () {
      this.loading = true
      // get by search keyword
      if (this.search) {
        axios
          .get(`/api/transact/notif-ppjk`, {
            params: {
              q: this.search,
              page: this.paginationNotifPPJK.page,
              rows: this.paginationNotifPPJK.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultNotifPPJK = res.data.rows
            this.totalNotifPPJK = res.data.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
      // get by sort option
      if (this.paginationNotifPPJK.sortBy && !this.search) {
        const direction = this.paginationNotifPPJK.descending ? 'desc' : 'asc'
        axios
          .get(`/api/transact/notif-ppjk`, {
            params: {
              order: direction,
              sort: this.paginationNotifPPJK.sortBy,
              page: this.paginationNotifPPJK.page,
              rows: this.paginationNotifPPJK.rowsPerPage
            }
          })
          .then(res => {
            this.loading = false
            this.dataResultNotifPPJK = res.data.rows
            this.totalNotifPPJK = res.data.total
          })
      }
      if (!this.search && !this.paginationNotifPPJK.sortBy) {
        axios
          .get(`/api/transact/notif-ppjk`, {
            params: {
              page: this.paginationNotifPPJK.page,
              rows: this.paginationNotifPPJK.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultNotifPPJK = res.data.rows
            this.totalNotifPPJK = res.data.meta.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
    },

    getDataBC20 () {
      this.loading = true
      // get by search keyword
      if (this.search) {
        axios
          .get(`/api/transact/notif-20`, {
            params: {
              q: this.search,
              page: this.paginationNotifTenantBC20.page,
              rows: this.paginationNotifTenantBC20.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultNotifTenantBC20 = res.data.rows
            this.totalNotifTenantBC20 = res.data.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
      // get by sort option
      if (this.paginationNotifTenantBC20.sortBy && !this.search) {
        const direction = this.paginationNotifTenantBC20.descending
          ? 'desc'
          : 'asc'
        axios
          .get(`/api/transact/notif-20`, {
            params: {
              order: direction,
              sort: this.paginationNotifTenantBC20.sortBy,
              page: this.paginationNotifTenantBC20.page,
              rows: this.paginationNotifTenantBC20.rowsPerPage
            }
          })
          .then(res => {
            this.loading = false
            this.dataResultNotifTenantBC20 = res.data.rows
            this.totalNotifTenantBC20 = res.data.total
          })
      }
      if (!this.search && !this.paginationNotifTenantBC20.sortBy) {
        axios
          .get(`/api/transact/notif-20`, {
            params: {
              page: this.paginationNotifTenantBC20.page,
              rows: this.paginationNotifTenantBC20.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultNotifTenantBC20 = res.data.rows
            this.totalNotifTenantBC20 = res.data.meta.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
    },

    getDataClosed () {
      this.loading = true
      // get by search keyword
      if (this.search) {
        axios
          .get(`/api/transact/notif-closed`, {
            params: {
              q: this.search,
              page: this.paginationNotifClosed.page,
              rows: this.paginationNotifClosed.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultClosed = res.data.rows
            this.totalNotifClosed = res.data.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
      // get by sort option
      if (this.paginationNotifClosed.sortBy && !this.search) {
        const direction = this.paginationNotifClosed.descending
          ? 'desc'
          : 'asc'
        axios
          .get(`/api/transact/notif-closed`, {
            params: {
              order: direction,
              sort: this.paginationNotifClosed.sortBy,
              page: this.paginationNotifClosed.page,
              rows: this.paginationNotifClosed.rowsPerPage
            }
          })
          .then(res => {
            this.loading = false
            this.dataResultClosed = res.data.rows
            this.totalNotifClosed = res.data.total
          })
      }
      if (!this.search && !this.paginationNotifClosed.sortBy) {
        axios
          .get(`/api/transact/notif-closed`, {
            params: {
              page: this.paginationNotifClosed.page,
              rows: this.paginationNotifClosed.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultClosed = res.data.rows
            this.totalNotifClosed = res.data.meta.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
    },

    getDataTenant () {
      this.loading = true
      // get by search keyword
      if (this.search) {
        axios
          .get(`/api/transact/notif-tenant`, {
            params: {
              q: this.search,
              page: this.paginationNotifTenant.page,
              rows: this.paginationNotifTenant.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultNotifTenant = res.data.rows
            this.totalNotifTenant = res.data.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
      // get by sort option
      if (this.paginationNotifTenant.sortBy && !this.search) {
        const direction = this.paginationNotifTenant.descending
          ? 'desc'
          : 'asc'
        axios
          .get(`/api/transact/notif-tenant`, {
            params: {
              order: direction,
              sort: this.paginationNotifTenant.sortBy,
              page: this.paginationNotifTenant.page,
              rows: this.paginationNotifTenant.rowsPerPage
            }
          })
          .then(res => {
            this.loading = false
            this.dataResultNotifTenant = res.data.rows
            this.totalNotifTenant = res.data.total
          })
      }
      if (!this.search && !this.paginationNotifTenant.sortBy) {
        axios
          .get(`/api/transact/notif-tenant`, {
            params: {
              page: this.paginationNotifTenant.page,
              rows: this.paginationNotifTenant.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultNotifTenant = res.data.rows
            this.totalNotifTenant = res.data.meta.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
    },

    getDataJkt () {
      this.loading = true
      // get by search keyword
      if (this.search) {
        axios
          .get(`/api/transact/notif-jkt`, {
            params: {
              q: this.search,
              page: this.paginationNotifJkt.page,
              rows: this.paginationNotifJkt.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultNotifJkt = res.data.rows
            this.totalNotifJkt = res.data.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
      // get by sort option
      if (this.paginationNotifJkt.sortBy && !this.search) {
        const direction = this.paginationNotifJkt.descending ? 'desc' : 'asc'
        axios
          .get(`/api/transact/notif-jkt`, {
            params: {
              order: direction,
              sort: this.paginationNotifJkt.sortBy,
              page: this.paginationNotifJkt.page,
              rows: this.paginationNotifJkt.rowsPerPage
            }
          })
          .then(res => {
            this.loading = false
            this.dataResultNotifJkt = res.data.rows
            this.totalNotifJkt = res.data.total
          })
      }
      if (!this.search && !this.paginationNotifJkt.sortBy) {
        axios
          .get(`/api/transact/notif-jkt`, {
            params: {
              page: this.paginationNotifJkt.page,
              rows: this.paginationNotifJkt.rowsPerPage
            }
          })
          .then(res => {
            this.dataResultNotifJkt = res.data.rows
            this.totalNotifJkt = res.data.meta.total
          })
          .catch(err => console.log(err.response.data))
          .finally(() => (this.loading = false))
      }
    }
  }
}
</script>


<style scoped>
.m-10 {
  margin: 10px;
}

.tableDashboard {
  width: 100%;
}

.tableDashboard > th {
  text-align: left !important;
}

.mb-5px {
  margin-bottom: 5px;
}

.theme--light.v-subheader {
  color: rgba(0, 0, 0, 1);
}
</style>
