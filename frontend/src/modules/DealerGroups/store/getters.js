export default {
  GET_DEALERGROUPS: (state) => state.dealerGroups,
  GET_ACTIVE_DEALERGROUPS: (state) => state.dealerGroups.filter((dealer) => dealer.status),
};
