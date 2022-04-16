export default {
  GET_ZONES: (state) => state.zones,
  GET_ACTIVE_ZONES: (state) => state.zones.filter((zone) => zone.status),
  GET_ZONE: (state) => state.zone,
};
