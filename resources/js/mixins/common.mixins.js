export const objectsFormat = {
    methods: {
        adaptObject(obj) {
            return obj.map(function (obj) {
                return {'id': obj.id, 'name': obj.group_name};
            });
        },
    }
}

export const priceFormat = {
    methods: {
        transformPrice: function(price) {
            this.salary_init = true;
            if(typeof price === 'string' || price instanceof String) {
                price = price.split(' ').join('');
            }

            if (!price) return 0;
            price = parseFloat(price).toString();
            let parts = price.split('.');
            parts[0] = parts[0].replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
            if (parts.length - 1) {
                parts[1] = parts[1].substr(0, 2);
                if (parts[1].length < 2) parts[1] += "0";
            }
            return parts[0] + ((parts.length - 1) ? ',' + parts[1] : '');
        },
    }
}
