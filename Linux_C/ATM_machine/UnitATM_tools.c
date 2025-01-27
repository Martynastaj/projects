#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <string.h>
#include <time.h>
#include "UnitATM_tools.h"

// pobieranie argumantow wejsiowych
int parse_arguments(int argc, char *argv[], int *scale, int *descriptor, int resources[3], unsigned int *seed, double *delay) {
    int opt;
    // -m i -t to paraetry obowiazkowe dlatego ustawiamy flage ze jesli ich nie ma to wyrzucany jest blad
    int m_flag = 0;
    int t_flag = 0;
    
    while ((opt = getopt(argc, argv, "u:m:t:s:d:")) != -1) {
        switch (opt) {
            case 'u':
                *scale = atoi(optarg);
                if (*scale < 0) {
                    fprintf(stderr, "BLAD: Skala musi być nieujemna.\n");
                    return -1;
                }
                break;
            case 'm': {
                m_flag=1;
                char *token = strtok(optarg, ":"); // ciag znakow jest rozdzielony przy pomocy dwukropka
                for (int i = 0; i < 3; i++) {
                    resources[i] = atoi(token);
                    if (resources[i] < 0) {
                        fprintf(stderr, "BLAD: Zasoby musza byc nieujemne.\n");
                        return -1;
                    }
                    token = strtok(NULL, ":");
                }
                break;
            }
            case 't':
                t_flag = 1;
                *descriptor = atoi(optarg);
                if (*descriptor < 0) {
                    fprintf(stderr, "BLAD: Deskryptor nie moze byc ujemny.\n");
                    return -1;
                }
                break;
            case 's':
                *seed = (unsigned int)atoi(optarg);
                break;
            case 'd':
                *delay = atof(optarg) / 100.0; // centylocekundy
                if (*delay <= 0) {
                    fprintf(stderr, "BLAD: Podaj dodatnie opoznienie.\n");
                    return -1;
                }
                break;
            default:
                return -1;
        }
    }
        if (!m_flag || !t_flag) {
        fprintf(stderr, "BŁĄD: Brak opcji -m lub -t\n");
        return -1;
    }
    return 0;
}

int calculate_tokens(int value, int pow10, int resources[3], int tokens[3]) {
    int denominations[3] = {5, 2, 1};
    int new_denominations[3];

    // tokeny przemnozone przez skale
    for (int i = 0; i < 3; i++) {
        new_denominations[i] = denominations[i] * pow10;
    }

    // warunek dla zasobow i liczby (value) pobranej na wejsciu
    for (int i = 0; i < 3; i++) {
        while (value >= new_denominations[i] && resources[i] > 0) {
            value -= new_denominations[i];
            resources[i]--;
            tokens[i]++;
        }

    printf("Zasoby %d: %d | ", denominations[i], resources[i]);
    }
    
    // reszta bedzie wtedy gdy petla przestanie dzialac bo juz nie bedziemy mogli uzyc nowych nominalow (beda za duze)
    printf("Reszta: ");
    return value;
}

void display_token_value(int descriptor, int tokens[3], int pow10, double delay) {
    int denominations[3] = {5, 2, 1};
    int total_tokens = tokens[0] + tokens[1] + tokens[2];
    int *output = malloc(total_tokens * sizeof(int));
   
    int index = 0;

    for (int i = 0; i < 3; i++) {
        for (int j = 0; j < tokens[i]; j++) {
            output[index++] = denominations[i] * pow10;
        }
    }

   for (int i = total_tokens; i > 0; i--) {
        int random_index = random() % i;
        dprintf(descriptor, "%d\n", output[random_index]);
        output[random_index] = output[i - 1];

        usleep((int)(delay * 1000000));
    }

    dprintf(descriptor, "\n");
    free(output);
}