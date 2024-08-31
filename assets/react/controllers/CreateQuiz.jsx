import { Button, Card, CircularProgress, Container, Grid, TextField, Typography } from '@mui/material'
import React from 'react'

export default function CreateQuiz() {


    const [generating, setGenerating] = React.useState(false);
    const handleSubmit = async (e) => {
        e.preventDefault();

        setGenerating(true);

        const formData = new FormData(e.target)
        const content = formData.get('content')

        const reponse = await fetch('/quizzes', {
            method: 'POST',
            body: JSON.stringify({ content }),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        setGenerating(false);
        const json = await reponse.json();


        window.location.href = '/quizzes/' + json.quiz.id;
    }

    return (
        <Container maxWidth="sm">
            <Grid container direction='row' justifyContent='center' alignItems='center'>
                <Typography fontWeight="bold" component="h3" variant='h3' marginY={5}>Make My Quizz</Typography>
            </Grid>
            <Grid item>
                <Card style={{ padding: 15 }} variant="outlined">
                    <form onSubmit={handleSubmit}>
                        <TextField fullWidth label="Générer Un quizz" name='content' />
                        <Button fullWidth style={{ marginTop: 20 }} type='submit' variant='contained'>
                            {generating ? <CircularProgress color='secondary' /> : 'Generate'}
                        </Button>
                    </form>
                </Card>
            </Grid>
        </Container>
    )
}

