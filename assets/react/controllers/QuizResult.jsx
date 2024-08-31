import { Chip, Container, Paper, Table, TableBody, TableCell, TableContainer, TableHead, TableRow } from '@mui/material';
import React from 'react'

export default function QuizResult(props) {

    const quizResult = JSON.parse(props.quizResult);

    console.log(quizResult);

    const getAnswerTitle = (result) => {
        return quizResult.quizz.questions
            .find(x => x.id == result.questionId).answers
            .find(x => x.id == result.answerId).title;
    }

    const getQuestionTitle = (questionId) => {
        return quizResult.quizz.questions.find(x => x.id == questionId).title;
    }

    const isCorrect = (result) => {
        const question = quizResult.quizz.questions.find(x => x.id == result.questionId);
        const answer = question.answers.find(x => x.id == result.answerId);

        return answer.isCorrect;
    }

    return (
        <Container>
            <TableContainer component={Paper}>
                <Table>
                    <TableHead>
                        <TableRow>
                            <TableCell>Question</TableCell>
                            <TableCell>Réponse</TableCell>
                            <TableCell>Etat</TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {quizResult.results.map(result => (
                            <TableRow key={result.questionId}>
                                <TableCell> {getQuestionTitle(result.questionId)} </TableCell>
                                <TableCell> {getAnswerTitle(result)} </TableCell>
                                <TableCell><Chip color={isCorrect(result) ? 'success' : 'error'} label={isCorrect(result) ? 'Bonne reponse' : 'Mauvaise'} /></TableCell>
                            </TableRow>
                        ))}
                    </TableBody>
                </Table>
            </TableContainer>
        </Container>
    )
}
