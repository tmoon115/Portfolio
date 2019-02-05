const _ = require('lodash');

const dragonBlank = {
  color: 'N/A',
  superlative_est: 'N/A',
  adjective_1: 'N/A',
  body_part_plural: 'N/A',
  body_part: 'N/A',
  noun_1: 'N/A',
  animal: 'N/A',
  adjective_2: 'N/A',
  adjective_3: 'N/A',
  adjective_4: 'N/A',
};

const dragonStory = _.template('The ${color} dragon is the ${superlative} dragon of all. It has '+
'${adjective_1} ${body_part_plural}, and a ${body_part} shaped like a ${noun_1}. It loves to eat ${animal}, although it will feast on nearly anything. '
'It is actually quite ${adjective_2} and ${adjective_3}. You must be ${adjective_4} around it, or you may end up as it's meal.');

module.exports = {
  dragon: {
    story: dragonStory,
    obj: dragonBlank,
  },
};