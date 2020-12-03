'use strict';
// eslint-disable-next-line @typescript-eslint/camelcase

// eslint-disable-next-line @typescript-eslint/camelcase
const codes_list = [];

const groups_list = [
    { group_id: 'A10', group_name: '클라이언트 타입' },
    { group_id: 'A20', group_name: '사용자 상태' }
];

const temp_codes_list = {
    A10: [
        { code_id: '001', code_name: 'Web' },
        { code_id: '002', code_name: 'iOS' },
        { code_id: '003', code_name: 'Android' }
    ],
    A20: [
        { code_id: '000', code_name: '인증대기' },
        { code_id: '010', code_name: '인증완료' }
    ]
};

groups_list.map(function(e) {
    codes_list.push({
        group_id: e.group_id,
        group_name: e.group_name
    });
});

Object.keys(temp_codes_list).map(function(group_code) {
    temp_codes_list[group_code].map(function(code) {
        codes_list.push({
            group_id: group_code,
            code_id: `${group_code}${code.code_id}`,
            code_name: code.code_name
        });
    });
});

codes_list.sort(function(first, second) {
    if (first.group_id > second.group_id) return 1;
    if (first.group_id < second.group_id) return -1;
    if (first.group_id === second.group_id) return 0;
});



module.exports = {
    up: async (queryInterface, Sequelize) => {
        /**
         * Add seed commands here.
         *
         * Example:
         * await queryInterface.bulkInsert('People', [{
         *   name: 'John Doe',
         *   isBetaMember: false
         * }], {});
         */

        var options = { raw: true };
        await queryInterface.sequelize.query("SET FOREIGN_KEY_CHECKS = 0").then(function () {
            return queryInterface.sequelize.query("truncate table codes", null, options);
        }).then(function () {
            return queryInterface.sequelize.query("SET FOREIGN_KEY_CHECKS = 1", null, options);
        });

        await queryInterface.bulkInsert("codes", codes_list, {});
    },

    down: async (queryInterface, Sequelize) => {
        /**
         * Add commands to revert seed here.
         *
         * Example:
         * await queryInterface.bulkDelete('People', null, {});
         */
        await queryInterface.bulkDelete("codes", null, {});
    }
};