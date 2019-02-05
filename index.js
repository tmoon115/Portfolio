'use strict';

const Alexa = require('alexa-app');
const app = new Alexa.app('MadLibs');
const AlexaSkill = require('./AlexaSkill');
const alexaSkill = new AlexaSkill();
const _ = require('lodash');

let fullStory = '';
let blank = {};
let nextQueryPrompt = '';

app.launch((req, res) => {
  const prompt = 'Welcome to the Mad Libs app. Which story would you like to hear?';
  const reprompt = 'I\'m confused. Try again.';
  res.say(prompt).reprompt(reprompt).shouldEndSession(false);
});

app.intent('story', {
  'slots': {
    'NAME': 'Stories',
  },
  'utterances': ['{Let\'s play|Let\'s hear} {|a} {NAME} {|story}'],
},
  (req, res) => {
    const chosenStory = req.slot('NAME');
    const reprompt = 'I can tell you about a dragon. ' +
      'Say, let\'s hear a dragon story.';
    if (_.isEmpty(chosenStory)) {
      const prompt = 'I\'m confused. Try again.';
      res.say(`${prompt} ${reprompt}`).reprompt(reprompt).shouldEndSession(false);
      return true;
    } else {
      alexaSkill.getStory(chosenStory, (err, story, obj) => {
        if (err) {
          const prompt = err;
          res.say(`${prompt} ${reprompt}`).reprompt(reprompt).shouldEndSession(false)
            .send();
          return true;
        }

        fullStory = story;
        blank = obj;

        res.session('story', chosenStory);
        res.session('query', 'color');
        nextQueryPrompt = 'Say a color.';
        res.say(`Let\'s get started! ${nextQueryPrompt}`).shouldEndSession(false).send();
        return false;
      });
    }
  }
);

app.intent('blank', {
  'slots': {
    'WORD': 'AMAZON.LITERAL',
  },
  'utterances': ['{|my} {|word} {|is} {WORD}'],
},
  (req, res) => {
    const word = req.slot('WORD');
    const query = req.session('query');

    if (!query) {
      const prompt = 'Hmm. I\'m not sure what story you want to hear.';
      const reprompt = 'I can tell you about dragons. ' +
        'Try saying, let\'s hear a dragon story.'
      res.say(`${prompt} ${reprompt}`).reprompt(reprompt).shouldEndSession(false);
      return true;
    }

    if (_.isEmpty(word)) {
      const prompt = 'Hmm. I\'m not sure what you said. Try again.';
      res.say(`${prompt} ${nextQueryPrompt}`).reprompt(nextQueryPrompt).shouldEndSession(false);
      return true;
    } else {

      blank[query] = word;

      //const vowelCheck = query.split('$');
      //if (vowelCheck.length > 1) {
        //blank[vowelCheck[vowelCheck.length - 1]] = alexaSkill.articleCheck(word);
      }

      let nextQuery = '';
      Object.keys(blank).some(key => {
        nextQuery = key;
        return blank[key] === 'N/A';
      });

      if (nextQuery === res.session('query')) {
        endGame(res, res.session('story'));
        return false;
      }
      res.session('query', nextQuery);
      const queryCheck = nextQuery.split('$');
      if (queryCheck.length > 1) {
        nextQuery = queryCheck[0];
      }
      nextQuery = nextQuery.split('_');
      nextQuery.splice(nextQuery.length - 1, 1);
      nextQuery = nextQuery.length > 1 ? nextQuery.join(' ') : nextQuery[0];
      const letters = nextQuery.split('');
      if (letters[0] === 'a') {
        nextQueryPrompt = `Say an ${nextQuery}.`;
        res.say(nextQueryPrompt).shouldEndSession(false).send();
        return false;
      }
      nextQueryPrompt = `Say a ${nextQuery}.`;
      res.say(nextQueryPrompt).shouldEndSession(false).send();
      return false;
    }
  }
);

const endGame = function (res, name) {
  if (name === 'dragon') {
    res.say(`Okay. Here\'s your story. ${fullStory({
      color: blank.color,
      superlative_est: blank.superlative_est,
      adjective_1: blank.adjective_1,
      body_part_plural: blank.body_part_plural,
      body_part: blank.body_part,
      noun_1: blank.noun_1,
      animal: blank.animal,
      adjective_2: blank.adjective_2,
      adjective_3: blank.adjective_3,
      adjective_4: blank.adjective_4,
    })} The End. Thanks for playing!`)
      .shouldEndSession(true).send();
    return false;
  }
};

app.error = (exception) => {
  console.log(exception);
  throw exception;
};

module.exports = app;