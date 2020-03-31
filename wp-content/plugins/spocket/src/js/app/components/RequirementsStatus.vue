<script>
import $ from 'jquery';
import queryString from 'query-string';

export default {
  props: {
    nonces: {
      type: Object,
      default () {
        return {};
      },
    },
    ajaxUrl: {
      type: String,
      default: '',
    },
    l10n: {
      type: Object,
      default () {
        return {};
      },
    },
  },
  data () {
    return {
      getRequirementsStatusInProgress: false,
      requirementsStatus: null,
    };
  },
  watch: {
    requirementsStatus (newRequirementsStatus) {
      this.$emit ('setRequirementsStatus', newRequirementsStatus);
    },
  },
  mounted () {
    this.getRequirementsStatus ();
  },
  methods: {
    getRequirementsStatus () {
      if (this.getRequirementsStatusInProgress) {
        return;
      }

      this.getRequirementsStatusInProgress = true;

      const queryArgs = {
        action: 'spocket_requirements_status',
        nonce: this.nonces.getRequirementsStatus,
      };
      const getRequirementsStatusUrl = `${this.ajaxUrl}?${queryString.stringify (queryArgs)}`;

      $.ajax ({
        url: getRequirementsStatusUrl,
        success: ({
          data: {
            requirementsStatus = {},
          } = {},
        } = {}) => {
          this.requirementsStatus = requirementsStatus;
        },
        error: () => {
          setTimeout (this.getRequirementsStatus, 1000);
        },
        complete: () => {
          this.getRequirementsStatusInProgress = false;
        },
      });
    },
    refreshRequirementsStatus () {
      this.requirementsStatus = null;
      this.getRequirementsStatus ();
    },
  },
};
</script>

<template>
  <div class="Spocket-RequirementsStatus">
    <p v-if="!requirementsStatus">
      Please wait, checking requirements...
    </p>
    <div
    v-else
    class="Spocket-RequirementsStatus-table"
    >
      <table class="wp-list-table widefat striped">
        <thead>
          <tr>
            <th>Component</th>
            <th>Status</th>
            <th>How to fix</th>
          </tr>
        </thead>
        <tbody>
          <tr
          v-for="(requirement, requirementId) in requirementsStatus"
          :key="requirementId"
          >
            <td>{{ requirement.title }}</td>
            <td>
              <div
              :style="{
                color: requirement.pass ? null : '#a00',
              }">
                {{ requirement.pass ? 'Passed' : 'Failed' }}
                <span
                v-if="!requirement.pass"
                :title="requirement.reason"
                class="dashicons dashicons-editor-help"
                />
              </div>
            </td>
            <td>
              <div
              v-if="!requirement.pass"
              v-html="requirement.solution"
              />
              <div v-else>/</div>
            </td>
          </tr>
        </tbody>
      </table>
      <a
      class="button"
      href="#"
      @click.prevent="refreshRequirementsStatus"
      >Refresh</a>
    </div>
  </div>
</template>

<style lang="scss">
.Spocket-RequirementsStatus-table table {
  margin-bottom: 20px;
}
</style>
