<script>
/* global SpocketData */
import RequirementsStatus from './components/RequirementsStatus.vue';
import SpocketStatus from './components/SpocketStatus.vue';
import '../../css/toplevel-menu.css';

export default {
  components: {
    RequirementsStatus,
    SpocketStatus,
  },
  data () {
    return {
      ajaxUrl: SpocketData.ajaxUrl,
      assetsSrcUrl: SpocketData.assetsSrcUrl,
      assetsUrl: SpocketData.assetsUrl,
      l10n: SpocketData.l10n,
      nonces: SpocketData.nonces,
      requirementsStatus: null,
      storeUrl: SpocketData.storeUrl,
      spocketAdminUrl: SpocketData.spocketAdminUrl,
      spocketAuthToken: SpocketData.spocketAuthToken,
      spocketUserId: SpocketData.spocketUserId,
      spocketShopUrl: SpocketData.spocketShopUrl,
    };
  },
  computed: {
    allRequirementsPassed () {
      if (!this.requirementsStatus) {
        return false;
      }

      return Object.values (this.requirementsStatus).find (
        requirement => !requirement.pass
      ) === undefined;
    },
  },
  methods: {
    setErrorMessage ({ message }) {
      // eslint-disable-next-line no-alert
      alert (message);
    },
    setRequirementsStatus (requirementsStatus) {
      this.requirementsStatus = requirementsStatus;
    },
  },
};
</script>

<template>
  <div class="wrap Spocket">
    <h1>
      <a
      href="https://www.spocket.co"
      rel="noopener"
      target="_blank"
      >
        <img
        :src="`${assetsUrl}/images/logo-dark.svg`"
        width="150"
        >
      </a>
    </h1>
    <RequirementsStatus
    v-if="!allRequirementsPassed"
    :ajax-url="ajaxUrl"
    :l10n="l10n"
    :nonces="nonces"
    @setRequirementsStatus="setRequirementsStatus"
    />
    <SpocketStatus
    v-else
    :ajax-url="ajaxUrl"
    :l10n="l10n"
    :nonces="nonces"
    :store-url="storeUrl"
    :spocket-admin-url="spocketAdminUrl"
    :spocket-auth-token="spocketAuthToken"
    :spocket-user-id="spocketUserId"
    :spocket-shop-url="spocketShopUrl"
    @setErrorMessage="setErrorMessage"
    />
  </div>
</template>

<style lang="scss">
.Spocket {
  max-width: 640px;
}

.Spocket h1 {
  margin-bottom: 20px;
}

.Spocket h1 a {
  display: inline-block;
}
</style>
