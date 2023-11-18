export const objectsFormat = {
    methods: {
        adaptObject(obj) {
            return obj.map(function (obj) {
                return {'id': obj.id, 'name': obj.group_name};
            });
        },
    }
}
