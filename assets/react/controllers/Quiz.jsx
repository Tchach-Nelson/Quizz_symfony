import { Button, Container, MobileStepper } from '@mui/material';
import React from 'react'
import Question from './Question';

export default function Quiz(props) {

    const quiz = JSON.parse(props.quiz)

    const [activeStep, setActiveStep] = React.useState(0);
    const [quizResult, setQuizResult] = React.useState([])

    const isLastQuestion = () => {
        return activeStep == quiz.questions.length - 1;
    }

    const handleSubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);

        quizResult.push({ questionId: quiz.questions[activeStep].id, answerId: parseInt(formData.get('answer')) });

        console.log(quizResult);

        if (!isLastQuestion()) {
            setActiveStep(activeStep + 1);
        }
        else {

            const reponse = await fetch('/quizzes/' + quiz.id, {
                body: JSON.stringify({ quizResult: quizResult }),
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const json = await reponse.json();
            window.location.href = '/quizzes/result/' + json.quizResult.id;
        }

    }

    return (
        <Container maxWidth="sm">
            <MobileStepper
                backButton={<Button style={{ visibility: "hidden" }}>Back</Button>}
                nextButton={<Button style={{ visibility: "hidden" }}>Next</Button>}
                activeStep={activeStep}
                steps={quiz.questions.length}
                position='static'
                variant='dots'
            />

            <form onSubmit={handleSubmit}>
                <Question question={quiz.questions[activeStep]} />
                <div style={{ marginTop: 10, textAlign: 'center' }}>
                    <Button type='submit' variant='contained'> {isLastQuestion() ? 'Terminer' : 'Suivant'}</Button>
                </div>
            </form>

        </Container>
    )
}

