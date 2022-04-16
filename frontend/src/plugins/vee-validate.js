import Vue from "vue";
import { setInteractionMode, ValidationProvider, ValidationObserver, extend } from "vee-validate";
import { alpha, required, email, min, max, confirmed, ext, regex } from "vee-validate/dist/rules";
import moment from "moment";

extend("required", {
  ...required,
  message: trans("The {_field_} field is required", {
    _field_: "{_field_}",
  }),
});

extend("email", {
  ...email,
  message: trans("The {_field_} field is not valid", {
    _field_: "{_field_}",
  }),
});

extend("ext", {
  ...ext,
  message: trans("The {_field_} type is not allowed", {
    _field_: "{_field_}",
  }),
});

extend("regex", {
  ...regex,
  message: trans("The {_field_} is not valid", {
    _field_: "{_field_}",
  }),
});

extend("max", {
  ...max,
  message: trans("The {_field_} field must not exceed {length} characters", {
    _field_: "{_field_}",
    length: "{length}",
  }),
});

extend("min", {
  ...min,
  message: trans("The {_field_} field must be at least {length} characters long", {
    _field_: "{_field_}",
    length: "{length}",
  }),
});

extend("confirmed", {
  ...confirmed,
  message: trans("The {_field_} must match with the {target} field", {
    _field_: "{_field_}",
    target: "{target}",
  }),
});

extend("alpha", {
  ...alpha,
  message: trans("The {_field_} type is not allowed", {
    _field_: "{_field_}",
  }),
});

extend("greater_than", {
  message: (field, param) => {
    console.log(param, `The minimum ${field} is should be greater than ${param?.[0] ?? 0}`);
    return `The minimum ${field} is should be greater than ${param?.[0] ?? 0}`;
  },
  validate(minValue, param) {
    return parseFloat(minValue ?? 0) > parseFloat(param?.[0] ?? 0);
  },
});

extend("overlapped", {
  message: trans("The {_field_} already exists from the list.", {
    _field_: "{_field_}",
  }),
  validate(time, timeslots) {
    return (
      timeslots
        .map((timeslot) => {
          const date = moment().format("YYYY-MM-DD");
          const [start, end] = timeslot.split("-");
          const startTime = moment(`${date} ${start}`);
          const endTime = moment(`${date} ${end}`);
          return moment(`${date} ${time}`).isBetween(startTime, endTime, null, "[]");
        })
        .filter((i) => i).length === 0
    );
  },
});

setInteractionMode("lazy");

Vue.component("validation-provider", ValidationProvider);
Vue.component("validation-observer", ValidationObserver);
