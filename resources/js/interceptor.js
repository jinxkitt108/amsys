import axios from "axios";

export default function setup() {
    axios.interceptors.response.use(
        function(response) {
            if (response.headers.location) {
                return axios.get(response.headers.location);
            }

            return Promise.resolve(response);
        },
        function(error) {
            return Promise.reject(error);
        }
    );
}
