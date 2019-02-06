
#Madibs app for Alexa

from __future__ import print_function

import requests

# Mad Lib imports and variables
import random
PERCENT_DELIMITER = '%';

def lambda_handler(event, context):
    print("event.session.application.applicationId=" +
          event['session']['application']['applicationId'])
    
    if event['session']['new']:
        on_session_started({'requestId': event['request']['requestId']},
                           event['session'])

    if event['request']['type'] == "LaunchRequest":
        return on_launch(event['request'], event['session'])
    elif event['request']['type'] == "IntentRequest":
        return on_intent(event['request'], event['session'])
    elif event['request']['type'] == "SessionEndedRequest":
        return on_session_ended(event['request'], event['session'])


def on_session_started(session_started_request, session):
    """ Called when the session starts """

    print("on_session_started requestId=" + session_started_request['requestId']
          + ", sessionId=" + session['sessionId'])


def on_launch(launch_request, session):
    """ Called when the user launches the skill without specifying what they
    want
    """

    print("on_launch requestId=" + launch_request['requestId'] +
          ", sessionId=" + session['sessionId'])
    
    # Launch Skill
    return initializeGame()


def on_intent(intent_request, session):
    # Sets up intents to be called

    print("on_intent requestId=" + intent_request['requestId'] +
          ", sessionId=" + session['sessionId'])

    intent = intent_request['intent']
    intent_name = intent_request['intent']['name']

    # intent handlers
    if intent_name == "MadlibsIntent":
        return getResponse(intent, session)
    elif intent_name == "AMAZON.HelpIntent":
        return initializeGame()
    elif intent_name == "AMAZON.StopIntent":
        return stopGame()
    elif intent_name == "AMAZON.CancelIntent":
        return stopGame()
    else:
        print(intent_name)
        raise ValueError("Invalid intent")

def on_session_ended(session_ended_request, session):
    # Called when user ends session
    
    print("on_session_ended requestId=" + session_ended_request['requestId'] +
          ", sessionId=" + session['sessionId'])
   

#Initialize madlibs game
def initializeGame():
    

    session_attributes = {}
    card_title = "Mad Libs"

    #Choosing the script
    script = selectFile()
    questions = getQuestions(script)
    index = 0
    NUM_QUESTIONS = len(questions)

    # Save the questions in session attributes for later use
    session_attributes = {'questions': questions, 'index': index, 'fileName': script}

    # Generate instruction output
    speech_output = "Let's play Mad Libs. I'm going to ask you " + str(NUM_QUESTIONS) + " questions. Say cancel to quit. Let's begin."
    speech_output = speech_output + " Give me a " + questions[index] + ". "
    reprompt_text = "Give me a " + questions[index] + ". "

    should_end_session = False
    return build_response(session_attributes, build_speechlet_response(
        card_title, speech_output, reprompt_text, should_end_session))

def getResponse(intent, session):
    #promt user

    # initialization 
    should_end_session = False
    session_attributes = {}
    card_title = 'Prompt'
    reprompt_text = "I am ready to read the script."

    if "questions" in session.get('attributes', {}):
        # Get attributes from the session
        questions = session['attributes']['questions']
        index = session['attributes']['index']
        fileName = session['attributes']['fileName']

        if(index < len(questions)): 
            # Get the user input answer
            answer = intent['slots']['Word']['value']
            if answer == 'cancel':
                return stopGame()

            speech_output = "You just said " + answer + ". "
            
            # Re ask the question if necessary
            reprompt_text = "Give me a " + questions[index] + ". ";
            
            # Update the state with the new responses
            questions[index] = answer
            index = index + 1

            # Check state
            if(index < len(questions)):
                speech_output = speech_output + "Please give me a " + questions[index] + ". "
                session_attributes = {'questions': questions, 'index': index, 'fileName': fileName}

            else:
                # read script
                should_end_session = True
                script = readScript(questions, fileName)
                
                speech_output = "Reading the script. " + script + " The End."
        else:
            speech_output = "index is less than length of questions " \
                            "Internal problem."
            reprompt_text = "I did not understand what you said."
    else:
        speech_output = "I did not understand what you said " \
                        "Please try again."
        reprompt_text = "I did not understand what you said."

    return build_response(session_attributes, build_speechlet_response(
        card_title, speech_output, reprompt_text, should_end_session))

# Chooses the script
def getQuestions(script):
    return getQuestionsAsArray([], script);

# Read the script based on the responses
def readScript(responses, madlibFile):
    return alexaSay(responses, madlibFile);

def stopGame():
    # Quitting the app
    should_end_session = True
    session_attributes = {}
    card_title = 'Stop'
    speech_output = "Goodbye."
    reprompt_text = ""
    return build_response(session_attributes, build_speechlet_response(
        card_title, speech_output, reprompt_text, should_end_session))

#Madlib Core

#Selects a random mad lib
def selectFile():
    madlibFile = "";
    randomInt = random.randint(1,4)
    if randomInt == 1:
        madlibFile = "ML_1.txt"
    elif randomInt == 2:
        madlibFile = "ML_2.txt"
    elif randomInt == 3:
        madlibFile = "ML_3.txt"
    elif randomInt == 4:
        madlibFile = "ML_4.txt"
    return madlibFile;

def alexaSay(responses, madlibFile):
    lineBuffer = '';
    indexPos = 0;
    lineBuffer = open(madlibFile,'r').read();
    while PERCENT_DELIMITER in lineBuffer:
        #Remove percents from script
        next_target = lineBuffer.find('%');
        lineBuffer = lineBuffer[:next_target] + responses[indexPos] +lineBuffer[(next_target+3):]
        indexPos = indexPos + 1;
    return lineBuffer

def getQuestionsAsArray(sub_array, madlibFile):
    i = 0
    q = 0
    with open(madlibFile) as myFile:
            sub_array = []
            for num, line in enumerate(myFile, 1):
                if PERCENT_DELIMITER in line:
                    index_of_percent = [i for i,x in enumerate(line) if x == PERCENT_DELIMITER];
                    q=0;
                    for element in index_of_percent:
                        if(q < len(index_of_percent)):
                            sub_array.append(line[index_of_percent[q] + 1]);
                            i = i+1;
                            q = q+1;
                            continue
                        else:
                            break;
            item = 0
            for element in sub_array:
                if('n' in sub_array[item]):
                    sub_array[item] = 'noun';
                elif('v' in sub_array[item]):
                    sub_array[item] = 'verb';
                elif('a' in sub_array[item]):
                    sub_array[item] = 'adjective';
                elif('l' in sub_array[item]):
                    sub_array[item] = 'animal';
                elif('f' in sub_array[item]):
                    sub_array[item] = 'type of food';

                item = item+1;
            return sub_array;


# Helpers that build the responses 


def build_speechlet_response(title, output, reprompt_text, should_end_session):
    return {
        'outputSpeech': {
            'type': 'PlainText',
            'text': output
        },
        'card': {
            'type': 'Simple',
            'title': 'SessionSpeechlet - ' + title,
            'content': 'SessionSpeechlet - ' + output
        },
        'reprompt': {
            'outputSpeech': {
                'type': 'PlainText',
                'text': reprompt_text
            }
        },
        'shouldEndSession': should_end_session
    }


def build_response(session_attributes, speechlet_response):
    return {
        'version': '1.0',
        'sessionAttributes': session_attributes,
        'response': speechlet_response
    }
